# SDK GERENCIANET FOR PHP

Sdk for Gerencianet Pagamentos' API.
For more informations about parameters and values, please refer to [Gerencianet](http://gerencianet.com.br) documentation.

[![Build Status](https://travis-ci.org/gerencianet/gn-api-sdk-php.svg)](https://travis-ci.org/gerencianet/gn-api-sdk-php)
[![Code Climate](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/gpa.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php)
[![Test Coverage](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/coverage.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/coverage)

## Installation
Require this package with [composer](https://getcomposer.org/):
```
$ composer require gerencianet/gerencianet-sdk-php
```
Or include it in your composer.json file:
```
...
"require": {
  "gerencianet/gerencianet-sdk-php": "3.*"
},
...
```
Install the dependencies
```
$ composer install
```

## Requirements
* PHP >= 5.6
* Extension ext-simplexml

## Tested with
```
php 5.6 and 7.X
```
## Getting started
Require the module and namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Gerencianet\Gerencianet;
```
Although the web services responses are in json format, the sdk will convert any server response to array. The code must be within a try-catch and exceptions can be handled as follow:
```php
try {
  /* code */
} catch(GerencianetException $e) {
  /* Gerencianet's api errors will come here */
} catch(Exception $ex) {
  /* Other errors will come here */
}
```

To begin, you must configure the parameters in the config.json file. Instantiate the information `client_id`, `client_secret` for your application and `sandbox` equal to *true*, if your environment is Homologation, or *false*, if it is Production. If you use Pix charges, inform in the attribute `pix_cert` the directory and name of your certificate in .pem format.

### For development environment
Instantiate the module passing using your client_id, client_secret and sandbox equals true:
```php
$options = [
  'client_id' => 'client_id',
  'client_secret' => 'client_secret',
  'pix_cert' => '../certs/developmentCertificate.pem',
  'sandbox' => true,
  'debug' => false,
  'timeout' => 30
];

$api = new Gerencianet($options);
```

### For production environment
To change the environment to production, just set the third sandbox to false:
```php
$options = [
  'client_id' => 'client_id',
  'client_secret' => 'client_secret',
  'pix_cert' => '../certs/productionCertificate.pem',
  'sandbox' => false,
  'debug' => false,
  'timeout' => 30
];

$api = new Gerencianet($options);
```

To generate your certificate open a ticket at https://gerencianet.com.br/fale-conosco informing your account number, application name and environment (Homologation/Production). Our team will return with the .p12 certificate for you to consume the endpoints.

For use in PHP, the certificate must be converted to .pem.
Below you will find example using the OpenSSL command for conversion.

### Command OpenSSL
```
// Gerar certificado e chave em único arquivo
openssl pkcs12 -in certificado.p12 -out certificado.pem -nodes
```

## Running examples
You can run using any web server, like Apache or nginx, or simple start a php server as follow:

```php
php -S localhost:9000
```

Then open any example in your browser.

:warning: Some examples require you to change some parameters to work, like `examples/charge/oneStepBillet.php` or `examples/pix/charge/create.php` where you must change the id parameter.


## Version Guidance

| Version | Status | Packagist | Repo | PHP Version |
| --- | --- | --- | --- | --- |
| 1.x | Maintained | `gerencianet/gerencianet-sdk-php` | [v1](https://github.com/gerencianet/gn-api-sdk-php/tree/1.x) | \>= 5.4 |
| 2.x | Maintained | `gerencianet/gerencianet-sdk-php` | [v2](https://github.com/gerencianet/gn-api-sdk-php/tree/2.x) | \>= 5.5 |
| 3.x | Maintained | `gerencianet/gerencianet-sdk-php` | [v3](https://github.com/gerencianet/gn-api-sdk-php) | \>= 5.6 |

## Additional Documentation

The full documentation with all available endpoints is in https://dev.gerencianet.com.br/.

## License ##
[MIT](LICENSE)
