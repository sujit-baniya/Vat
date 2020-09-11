<?php
use MadeITBelgium\Vat\Vat;
use PHPUnit\Framework\TestCase;

class VatTest extends TestCase
{
    public function setUp(): void
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
    
    public function testOGM() {
        $ogm = new Vat;
        $this->assertEquals("000000000101", $ogm->generateOGM(1));
    }
    
    public function testOGMMetPrefix() {
        $ogm = new Vat;
        $this->assertEquals("111000000195", $ogm->generateOGM(1, "111"));
    }
    
    public function testOGMMetPrefixFormat() {
        $ogm = new Vat;
        $this->assertEquals("333/0000/00290", $ogm->generateOGM(2, "333", true));
    }
}
