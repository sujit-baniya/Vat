# PHP VAT Library
[![Build Status](https://travis-ci.org/MadeITBelgium/Vat.svg?branch=master)](https://travis-ci.org/MadeITBelgium/Vat)
[![Coverage Status](https://coveralls.io/repos/github/MadeITBelgium/vat/badge.svg?branch=master)](https://coveralls.io/github/MadeITBelgium/vat?branch=master)
[![Latest Stable Version](https://poser.pugx.org/madeitbelgium/vat/v/stable.svg)](https://packagist.org/packages/madeitbelgium/vat)
[![Latest Unstable Version](https://poser.pugx.org/madeitbelgium/vat/v/unstable.svg)](https://packagist.org/packages/madeitbelgium/vat)
[![Total Downloads](https://poser.pugx.org/madeitbelgium/vat/d/total.svg)](https://packagist.org/packages/madeitbelgium/vat)
[![License](https://poser.pugx.org/madeitbelgium/vat/license.svg)](https://packagist.org/packages/madeitbelgium/vat)

# Installation

Require this package in your `composer.json` and update composer.

```php
"madeitbelgium/vat": "^1.6"
```
Or
```php
composer require madeitbelgium/vat
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
MadeITBelgium\Vat\ServiceProvider\Vat::class,
```

You can use the facade for shorter code. Add this to your aliases:

```php
'Vat' => MadeITBelgium\Vat\Facade\Vat::class,
```

# Documentation
## Validation
```php
$vatnr = "BE....";
$vat = new Vat($vatnr);
if($vat->isVatValid()) {
    echo "VAT is valid!";
}
```
### laravel validation
```php
$this->validate($request, ['vatnumber' => 'vat']);
```
When the service is down a ServiceUnavailableException exception is thrown. To allow the validation to succeed when the service is down you can add an option with the default value when to the validation.
```php
$this->validate($request, ['vatnumber' => 'vat:true']);
```

## Format (Not working)
```php
$vatnr = "BE....";
$vat = new Vat($vatnr);
echo $vat->vatFormat();
```


## Genearte OGM
```php
$generator = new Vat;
echo $generator->generateOGM(1); //Output: 000000000101
echo $generator->generateOGM(1, "111"); //Output: 111000000195
echo $generator->generateOGM(2, "333", true); //Output: 333/0000/00290
```

## Parse data
```php
use MadeITBelgium\Vat\Facade\Vat;
$data = Vat::setVat($vatNr)->parse();
dd($data);

/*
countryCode: "",
valid: true,
name: "",
zipcode: "",
city: "",
street: "",
address: "",
*/
```

The complete documentation can be found at: [http://www.madeitbelgium.org/my-projects/php-vat-library/](http://www.madeitbelgium.org/my-projects/php-vat-library/)

# Support

Support github or mail: tjebbe.lievens@madeit.be

# Contributing

Please try to follow the psr-2 coding style guide. http://www.php-fig.org/psr/psr-2/

# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!
