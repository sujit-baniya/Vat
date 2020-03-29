<?php namespace MadeITBelgium\Vat\Validation;

use MadeITBelgium\Vat\Vat;

class Validator
{
    public function isVat($value)
    {
        $vat = new Vat($value);
        return $vat->isVatValid();
    }
}
