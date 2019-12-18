<?php namespace TPWeb\Vat\Validation;

use TPWeb\Vat\Vat;
use TPWeb\Vat\Validation\Validator;
use TPWeb\Vat\ServiceUnavailableException;

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
		try {
		    return $this->validator->isVat($value);
		} catch(ServiceUnavailableException $e) {
		    if(isset($parameters[0])) {
			return $parameters[0] == 'true';
		    }
		}
		return false;
	}
}
