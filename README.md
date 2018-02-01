# Easily fetch information on a EU business from a VAT Number

This package allow you to fetch information on EU businesses with the VIES API.

```php
use Depsimon\Vies;

$information = LaravelVies::getInfo($countryCode, $vatNumber);
```
## Installation

You can install the package via composer:

```bash
composer require depsimon/vies
```