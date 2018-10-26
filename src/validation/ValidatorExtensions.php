<?php namespace TPWeb\Vat\Validation;

use TPWeb\Vat\Vat;
use TPWeb\Vat\Validation\Validator;

class ValidatorExtensions
{
	/**
	 * @var TPWeb\Vat\Validation\Validator
	 */
	private $validator;

	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}
	
	public function validateVat($attribute, $value, $parameters)
	{
        	return $this->validator->isVat($value);
	}
}
