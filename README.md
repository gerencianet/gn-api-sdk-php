![SDK Gerencianet for PHP](https://media-exp1.licdn.com/dms/image/C4D1BAQH9taNIaZyh_Q/company-background_10000/0/1603126623964?e=2159024400&v=beta&t=coQC_AK70vTYL3NdvbeIaeYts8nKumNHjvvIGCmq5XA)
 
<h1 align="center">SDK Gerencianet for PHP</h1>

SDK for Gerencianet Pagamentos' API.
For more informations about parameters and values, please refer to [Gerencianet](http://gerencianet.com.br) documentation.

[![Build Status](https://travis-ci.org/gerencianet/gn-api-sdk-php.svg)](https://travis-ci.org/gerencianet/gn-api-sdk-php)
[![Code Climate](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/gpa.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php)
[![Test Coverage](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/coverage.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/coverage)

## Installation
Clone this repository and execute the following command to install the dependencies
```
$ composer install
```

If you already have a project with composer, include the dependency in your composer.json file:
```
...
"require": {
  "gerencianet/gerencianet-sdk-php": "4.*"
},
...
```

Or require this package with [composer](https://getcomposer.org/):
```
$ composer require gerencianet/gerencianet-sdk-php
```

## Requirements
* PHP >= 7.2
* Guzzle >= 7.0
* Extension ext-simplexml

## Tested with
```
php 7.2 and 7.4
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

**To generate your certificate:** Access the menu API (1)-> Meus Certificados (2) and choose the environment you want the certificate: Produção or Homologação -> click in Novo Certificado (3). 
![To generate your certificate](https://app-us-east-1.t-cdn.net/5fa37ea6b47fe9313cb4c9ca/posts/603543f7d1778b2d725dea1e/603543f7d1778b2d725dea1e_85669.png)

**Create a new application to use the Pix API:** Access the menu API (1)-> Minhas Aplicações -> Nova Aplicação(2) -> Ative API Pix (3) and choose the scopes you want to release in Produção e/ou Homologação (remembering that these can be changed later). -> click in Criar Nova aplicação(4).
![Create a new application to use the Pix API](https://t-images.imgix.net/https%3A%2F%2Fapp-us-east-1.t-cdn.net%2F5fa37ea6b47fe9313cb4c9ca%2Fposts%2F603543ff4253cf5983339cf1%2F603543ff4253cf5983339cf1_88071.png?width=1240&w=1240&auto=format%2Ccompress&ixlib=js-2.3.1&s=2f24c7ea5674dbbea13773b3a0b1e95c)


**Change an existing application to use the Pix API:** Access the menu API (1)-> Minhas Aplicações e escolha a sua aplicação (2) -> Editar(Botão laranja) -> Ative API Pix (3) and choose the scopes you want to release in Produção e/ou Homologação. -> click in Atualizar aplicação (4).
![Change an existing application to use the Pix API](https://app-us-east-1.t-cdn.net/5fa37ea6b47fe9313cb4c9ca/posts/603544082060b2e9b88bc717/603544082060b2e9b88bc717_22430.png)


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
| 3.x | Maintained | `gerencianet/gerencianet-sdk-php` | [v3](https://github.com/gerencianet/gn-api-sdk-php/tree/3.x) | \>= 5.6 |
| 4.x | Maintained | `gerencianet/gerencianet-sdk-php` | [v4](https://github.com/gerencianet/gn-api-sdk-php) | \>= 7.2 |

## Additional Documentation

The full documentation with all available endpoints is in https://dev.gerencianet.com.br/.

## License ##
[MIT](LICENSE)
