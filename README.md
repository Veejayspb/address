Object oriented wrapper for parse_url
=====================================
Wrapper for function
[parse_url()](https://www.php.net/manual/ru/function.parse-url.php)
in OOP-style. Allows you to parse, modificate and create url.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Veejayspb/address/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Veejayspb/address/?branch=master)

Examples
--------
```php
$url = 'https://domain.ru/index.php?arg=value#anchor';
$address = new \veejay\address\Address($url);

// Relative address
$address->path = 'test.php';
$address->fragment = 'h1';
echo $address->rel(); // /test.php?arg=value#h1

// Absolute address
$address->query = ['param' => 1];
$address->fragment = null;
echo $address->abs(); // https://domain.ru/test.php?param=1
```

Requirements
------------
- PHP 7.0+

Installation
------------
```
composer require "veejay/address"
```
