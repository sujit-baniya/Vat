<?php namespace MadeITBelgium\Vat\validation;

use MadeITBelgium\Vat\Vat;
use MadeITBelgium\Vat\Validation\Validator;
use MadeITBelgium\Vat\ServiceUnavailableException;

class ValidatorExtensions
{
    /**
     * @var MadeITBelgium\Vat\Validation\Validator
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
