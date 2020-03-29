<?php namespace MadeITBelgium\Vat\validation;

use MadeITBelgium\Vat\Vat;

class Validator
{
    public function isVat($value)
    {
        $vat = new Vat($value);
        return $vat->isVatValid();
    }
}
