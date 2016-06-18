# PHP VAT Library
[![Build Status](https://travis-ci.org/TPWeb/Vat.svg?branch=master)](https://travis-ci.org/TPWeb/Vat)
[![Coverage Status](https://coveralls.io/repos/github/TPWeb/vat/badge.svg?branch=master)](https://coveralls.io/github/TPWeb/vat?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tpweb/vat/v/stable.svg)](https://packagist.org/packages/tpweb/vat)
[![Latest Unstable Version](https://poser.pugx.org/tpweb/vat/v/unstable.svg)](https://packagist.org/packages/tpweb/vat)
[![Total Downloads](https://poser.pugx.org/tpweb/vat/d/total.svg)](https://packagist.org/packages/tpweb/vat)
[![License](https://poser.pugx.org/tpweb/vat/license.svg)](https://packagist.org/packages/tpweb/vat)

#Installation

Require this package in your `composer.json` and update composer.

```php
"tpweb/vat": "~1.*"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
TPWeb\Vat\VatServiceProvider::class,
```

You can use the facade for shorter code. Add this to your aliases:

```php
'Vat' => TPWeb\Vat\VatFacade::class,
```

# Documentation
## Validation
```php
$vatnr = "BE....";
$vat = new Vat($vatnr);
```
## Calculation
```php
$vatnr = "BE....";
$vat = new Vat($vatnr);
```


The complete documentation can be found at: [http://www.tpweb.org/my-projects/php-vat-library/](http://www.tpweb.org/my-projects/php-vat-library/)

# Support

Support github or mail: tjebbe.lievens@madeit.be

# Contributing

Please try to follow the psr-2 coding style guide. http://www.php-fig.org/psr/psr-2/

# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!