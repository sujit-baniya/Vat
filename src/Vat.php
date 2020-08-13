<?php
namespace MadeITBelgium\Vat;

use SoapClient;
use SoapFault;
use Exception;

/**
 *
 * PHP Vat Library
 *
 * @version    1.0.0
 * @package    madeitbelgium/vat
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Vat
{
    protected $version = '1.0.0';
    private $vat;
    private $number;
    private $country;
    private $data;
    
    const VAT_SERVICE_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * Construct Vat
     * @param $vat
     */
    function __construct($vat = null) {
        if($vat != null) {
            $this->setVat($vat);
        }
        return $this;
    }

    /**
     * Set vat
     * @param  String		$vat
     */
    public function setVat($vat) {
        $this->vat = $vat;
        $this->data = null;
        if($vat != null && strlen($vat) > 0) {
            $this->vat = $this->VatClearFormat();
            $this->number = $this->setNumber();
            $this->country = $this->setCountry();
        }
        return $this;
    }

    /**
     * Get vat
     * @return String
     */
    public function getVat() {
        return $this->vat;
    }
    
    /**
     * Get Country
     * @return Country
     */
    public function getCountry() {
        return $this->country;
    }
    
    /**
     * Get Number
     * @return Number
     */
    public function getNumber() {
        return $this->number;
    }
    
    public function isVatValid() {
        if(empty($this->data)) {
            $this->load();
        }
        
        return $this->data->valid ?? false;
    }
    
    public function get() {
        $this->load();
        return $this->data;
    }
    
    public function parse() {
        if(empty($this->data)) {
            $this->load();
        }
        
        $street = null;
        $zipcode = null;
        $city = null;
        
        if(isset($this->data->address)) {
            $data = explode("\n", $this->data->address);
            $j = 0;
            for($i = 0; $i < count($data); $i++) {
                if(!empty($data[$i])) {
                    if($j === 0) {
                        $street = $data[$i];
                    } else if($j === 1) {
                        $zipcode = substr($data[$i], 0, strpos($data[$i], ' '));
                        $city = trim(substr($data[$i], strpos($data[$i], ' ')));
                    }
                    
                    $j++;
                }
            }
        }
        
        return (object) [
            'countryCode' => $this->data->countryCode ?? null,
            'vatNumber' => $this->data->vatNumber ?? null,
            'requestDate' => $this->data->requestDate ?? null,
            'valid' => $this->data->valid ?? false,
            'name' => $this->data->name ?? null,
            'street' => $street,
            'zipcode' => $zipcode,
            'city' => $city,
            'address' => $this->data->address ?? null,
        ];
    }

    public function load() {
        try {
            $client = new SoapClient(self::VAT_SERVICE_URL);
        } catch (SoapFault $e) {
            $client = false;
        }
        if ($client) {
            try {
                
                $result = $client->checkVat([
                    'countryCode' => $this->country,
                    'vatNumber'   => $this->number,
                ]);
                $this->data = $result;
                return $this;
            } catch (SoapFault $e) {
                if($e->getMessage() === "INVALID_INPUT") {
                    throw new Exception('Invalid input ' . $this->country . ' ' . $this->number);
                }
                if($e->getMessage() === 'SERVICE_UNAVAILABLE') {
                    throw new ServiceUnavailableException('The VAT check service is currently unavailable. Please try again later.', $e);
                }
                /*if($e->getMessage() !== "MS_UNAVAILABLE") {
                    return $this;
                }*/
            }
        }
        throw new ServiceUnavailableException('The VAT check service is currently unavailable. Please try again later.');
    }
    
    public function vatClearFormat() {
        $vat = str_replace([' ', '-', '.', ','], '', trim($this->vat));
        $vat = preg_replace('/[^a-zA-Z0-9]/', '', $vat);
        return $vat;
    }
    
    public function format() {
        if($this->country === 'BE') {
            return substr($this->vat, 0, 3) . wordwrap(substr($this->vat, 3), 3, '.', true);
        }
        return $this->vat;
    }
    
    private function setCountry() {
        $countryCode = substr($this->vat, 0, 2);
        return $countryCode;
    }
    
    private function setNumber() {
        $number = substr($this->vat, 2);
        return $number;
    }
    
    public function generateOGM($number, $prefix = "", $format = false) {
        $ogmPrefix = $prefix . str_pad($number, 10 - strlen($prefix), "0", STR_PAD_LEFT);
        $numeric = intval($ogmPrefix);
        $rest = $numeric % 97;
        if ($rest < 10) {
            $nul = 0;
            $rest = $nul.$rest;
        }
        $ogm = $ogmPrefix . $rest;
        
        if($format) {
            return substr($ogm, 0, 3) . "/" . substr($ogm, 3, 4) . "/" . substr($ogm, 7, 5);
        }
        return $ogm;
    }
}
