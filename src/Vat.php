<?php
namespace TPWeb\Vat;

use SoapClient;
use SoapFault;
use Exception;

/**
 *
 * PHP Vat Library
 *
 * @version    1.0.0
 * @package    tpweb/vat
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
    
    const VAT_SERVICE_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatTestService.wsdl';

    /**
     * Construct Vat
     * @param $vat
     */
    function __construct($vat = null) {
        if($vat != null) {
            $this->setVat($vat);
        }
    }

    /**
     * Set vat
     * @param  String		$vat
     */
    public function setVat($vat) {
        $this->vat = $vat;
        if($vat != null && strlen($vat) > 0) {
            $this->vat = $this->VatClearFormat();
            $this->number = $this->setNumber();
            $this->country = $this->setCountry();
        }
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
                return $result->valid;
            } catch (SoapFault $e) {
                if($e->getMessage() !== "MS_UNAVAILABLE") {
                    return false;
                }
            }
        }
        throw new Exception('The VAT check service is currently unavailable. Please try again later.');
        
    }
    
    public function vatClearFormat() {
        $vat = str_replace([' ', '-', '.', ','], '', trim($this->vat));
        $vat = preg_replace('/[^a-zA-Z0-9]/', '', $vat);
        return $vat;
    }
    
    public function vatFormat() {
        return substr($this->vat, 0, 2) . wordwrap(substr($this->vat, 2), 3, '.', true);
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
    
    public function ip($ip) {
        $response = file_get_contents('http://ip2c.org/' . $ip);
        if(!empty($response)) {
            $parts = explode( ';', $response );
            return $parts[1] === 'ZZ' ? '' : $parts[1];
        }
        return '';
    }
}
