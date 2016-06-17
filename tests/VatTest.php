<?php
use TPWeb\Vat\Vat;

class VatTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testConstructor()
    {
        $vat = new Vat("BE");
        $this->assertEquals("BE", $vat->getVat());
    }
    
    public function testGetCountry()
    {
        $vat = new Vat("BE123");
        $this->assertEquals("BE", $vat->getCountry());
    }
    
    public function testGetNumber()
    {
        $vat = new Vat("BE123");
        $this->assertEquals("123", $vat->getNumber());
    }
    
    public function testValidatorVat() {
        $validator = new Vat("BE0653.855.818");
        $this->assertTrue($validator->isVatValid());
    }
}