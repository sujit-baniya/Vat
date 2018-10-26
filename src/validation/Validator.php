<?php namespace TPWeb\Vat\Validation;

use TPWeb\Vat\Vat;

class Validator
{
	public function isVat($value)
	{
		$vat = new Vat($value);
		return $vat->isVatValid();
	}
}
