<h1 align="center">SDK Gerencianet for PHP</h1>

![Gerencianet is now Efí](https://sejaefi.link/rylucSCXT3)

<div style='border: 1px solid rgba(255,105,0,0.47); border-radius: 8px 8px 8px 8px; padding: 10px;'>

<h3 style="color: #f37021; font-weight: bold;">News!</h3>

Initially, the rebranding will not impact the integrations and communication with the system you are already using with Gerencianet.

- **For those of you who are just joining us**, we recommend starting your integration with the new Efí SDK right away. [Visit our new GitHub repository](https://github.com/efipay/sdk-php-apis-efi).

- **If you already have a system using Gerencianet's SDK**, we emphasize the importance of *migrating to the new Efí SDK*, which is crucial to ensure that you are well-prepared for future innovations! To facilitate this process, we have developed the **Migration Validator**. [See more details](#migration-validator).
</div>

---
<p align="center">
  <a href="https://github.com/gerencianet/gn-api-sdk-php">Portuguese</a> |
  <span><b>English</b></span>  
</p>

---

[![Latest Stable Version](http://poser.pugx.org/gerencianet/gerencianet-sdk-php/v)](https://packagist.org/packages/gerencianet/gerencianet-sdk-php)
[![License](http://poser.pugx.org/gerencianet/gerencianet-sdk-php/license)](https://packagist.org/packages/gerencianet/gerencianet-sdk-php)
[![Total Downloads](http://poser.pugx.org/gerencianet/gerencianet-sdk-php/downloads)](https://packagist.org/packages/gerencianet/gerencianet-sdk-php)
[![Code Climate](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/gpa.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php)

SDK in PHP for integration with Gerencianet APIs for emission Pix, bank slips, carnet, credit card, subscription, payment link, marketplance, Pix through Open Finance, among other features.
For more informations about [parameters](http://dev.gerencianet.com.br) and [values](http://gerencianet.com.br/tarifas) see our website.

Jump To:
- [**Requirements**](#requirements)
- [**Tested with**](#tested-with)
- [**Installation**](#installation)
- [**Getting started**](#getting-started)
	- [**For homologation environment**](#for-homologation-environment)
	- [**For production environment**](#for-production-environment)
- [**How to get Client-Id and Client-Secret credentials**](#how-to-get-client-id-and-client-secret-credentials)
- [**How to generate a Pix certificate**](#how-to-generate-a-pix-certificate)
- [**How to register Pix keys**](#how-to-register-pix-keys)
	- [**Register Pix key via mobile app:**](#register-pix-key-via-mobile-app)
	- [**Register Pix key via API:**](#register-pix-key-via-api)
- [**Running examples**](#running-examples)
- [**Version Guidance**](#version-guidance)
- [**Additional Documentation**](#additional-documentation)
- [**Migration Validator**](#migration-validator)
	- [How to Use the Validator:](#how-to-use-the-validator)
- [**License**](#license)

---

## **Requirements**
* PHP >= 7.2
* Guzzle >= 7.0

## **Tested with**
```
PHP 7.2, 7.3, 7.4, 8.0 and 8.1
```

## **Installation**
Clone this repository and execute the following command to install the dependencies
```
composer install
```

Or if you already have a project with composer, include the dependency in your composer.json file:
```
...
"require": {
  "gerencianet/gerencianet-sdk-php": "^5"
},
...
```

Or download this package direct with [composer](https://getcomposer.org/):
```
composer require gerencianet/gerencianet-sdk-php
```

## **Getting started**

To begin, you must configure the parameters in the `/examples/credentials/options.php` file. Instantiate the information `client_id`, `client_secret` for authentication and `sandbox` equal to *true*, if your environment is Homologation, or *false*, if it is Production. If you use Pix charges, inform in the attribute `certificate` with the relative **absolute** directory and name of your certificate in `.p12` or `.pem`. format.

See configuration examples below:

### **For homologation environment**
Instantiate the module parameters using `client_id`, `client_secret`, `sandbox` equal to **true** and `certificate` with the name of the approval certificate:
```php
$options = [
	"client_id" => "Client_Id...",
	"client_secret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/homologation.p12"), // Absolute path to the certificate in .p12 or .pem format
	"sandbox" => true,
	"debug" => false,
	"timeout" => 30
];
```

### **For production environment**
Instantiate the module parameters using `client_id`, `client_secret`, `sandbox` equals *false* and `certificate` with the name of the production certificate:
```php
$options = [
	"client_id" => "Client_Id...",
	"client_secret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/production.p12"), // Absolute path to the certificate in .p12 or .pem format
	"sandbox" => false,
	"debug" => false,
	"timeout" => 30
];
```

Require the module and namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
```
Although the web services responses are in json format, the SDK will convert any server response to array. The code must be within a try-catch and exceptions can be handled as follow:
```php
try {
  /* call the desired function */
} catch(GerencianetException $e) {
  /* Gerencianet API errors will come here */
} catch(Exception $e) {
  /* Other errors will come here */
}
```

## **How to get Client-Id and Client-Secret credentials**

**Create a new application to use the Gerencianet API:** 
1. Access the Gerencianet panel in the **API** menu.
2. In the side menu, click on **Aplicações** then on **Criar aplicação**.
3. Enter a name for the application, and select which API you want to activate: **API de emissões** (slips and booklets) and/or **API Pix** and/or Payments. In this case, API Pix; these can be changed later).
4. Select the Scopes of Production and Scopes of Homologation (Development) that you want to release;
5. Click **Criar aplicação**.
6. Enter your Electronic Signature to confirm the changes and update the application.

## **How to generate a Pix certificate**

All Pix requests must contain a security certificate that will be provided by Gerencianet within your account, in PFX(.p12) format. This requirement is fully described in the .[PIX security manual](https://www.bcb.gov.br/estabilidadefinanceira/comunicacaodados).

**To generate your certificate:**
1. Access the Gerencianet panel in the **API** menu.
2. In the left corner, click on **Meus certificados** and choose the environment in which you want the certificate: **Produção** or **Homologação**.
3. Click **Criar certificado**.
4. Enter your Electronic Signature to confirm the change.

## **How to register Pix keys**
The registration of Pix keys can be done through the Gerencianet application or through an API endpoint. Below you will find the steps on how to register them.

### **Register Pix key via mobile app:**
If you don't already have our app installed, click on [Android](https://play.google.com/store/apps/details?id=br.com.gerencianet.app) or [iOS](https://apps.apple.com/br/app/gerencianet/id1443363326), according to your smartphone's operating system, to download it.

To register your Pix keys through the application:
1. Access your account through **app Gerencianet**.
2. In the side menu, touch **Pix** to start your registration.
3. Touch **Minhas Chaves** and then **Cadastrar Chave**.
4. You must choose at least 1 of the 4 available key options (CPF/CNPJ, cell phone, email or random key).
5. After registering the desired Pix keys, click **Continuar**.
6. Enter your Electronic Signature to confirm registration.

### **Register Pix key via API:**
The endpoint used to create a random Pix key (evp), is `POST /v2/gn/evp` ([Register evp key](https://dev.gerencianet.com.br/docs/api-pix-endpoints#section-criar-chave-evp)). A detail is that, through this endpoint, only random Pix keys are registered.

To consume it, just run the `/examples/exclusive/key/pixCreateEvp.php` example from our SDK. The request sent to this endpoint does not need a body.

The example response below represents Success (201), showing the registered Pix key.
```json
{
  "chave": "345e4568-e89b-12d3-a456-006655440001"
}
```


## **Running examples**
You can run it using any web server like apache or nginx and open any example in your browser.

:warning: Some examples require you to change some parameters to work, like `/examples/charges/billet/createOneStepBillet.php` or `/examples/pix/cob/pixCreateCharge.php`.


## **Version Guidance**

The Gerencianet PHP SDK is still operational, but it has been discontinued and will no longer receive updates. We recommend migrating to Efí's new SDK to continue enjoying our services and updates. Learn more at: [github.com/efipay/sdk-php-apis-efi](https://github.com/efipay/sdk-php-apis-efi).

| Version | Status | Packagist | Repo | Version PHP |
| --- | --- | --- | --- | --- |
| 1.x | Discontinued | [/gerencianet/gerencianet-sdk-php#1.0.17](https://packagist.org/packages/gerencianet/gerencianet-sdk-php#1.0.17) | [v1](https://github.com/gerencianet/gn-api-sdk-php/tree/1.x) | \>= 5.4 |
| 2.x | Discontinued | [/gerencianet/gerencianet-sdk-php#2.4.1](https://packagist.org/packages/gerencianet/gerencianet-sdk-php#2.4.1) | [v2](https://github.com/gerencianet/gn-api-sdk-php/tree/2.x) | \>= 5.5 |
| 3.x | Discontinued | [/gerencianet/gerencianet-sdk-php#3.2.0](https://packagist.org/packages/gerencianet/gerencianet-sdk-php#3.2.0) | [v3](https://github.com/gerencianet/gn-api-sdk-php/tree/3.x) | \>= 5.6 |
| 4.x | Maintained | [/gerencianet/gerencianet-sdk-php#4.1.1](https://packagist.org/packages/gerencianet/gerencianet-sdk-php#4.1.1) | [v4](https://github.com/gerencianet/gn-api-sdk-php/tree/4.x) | \>= 7.2 |
| 5.x | Maintained | [/gerencianet/gerencianet-sdk-php](https://packagist.org/packages/gerencianet/gerencianet-sdk-php) | [v5](https://github.com/gerencianet/gn-api-sdk-php) | \>= 7.2 |

## **Additional Documentation**

Complete documentation with all endpoints and API details is available at https://dev.gerencianet.com.br/.

If you don't have a Gerencianet digital account yet, [open yours now](https://sistema.gerencianet.com.br/)!

## **Migration Validator**
The Efí Pay SDK Migration Validator makes the migration process smoother and more efficient. **This tool does not modify your code**, it only analyzes the existing code for specific patterns related to classes and methods that have been modified in the new version of the SDK.

Before making any modifications to your application's code, it is highly advisable to create a complete backup of your entire project.

### How to Use the Validator:
1. Download the [Migration Validator](https://raw.githubusercontent.com/gerencianet/gn-api-sdk-php/master/migrationChecker.php).
2. Make sure to place the `migrationChecker.php` file in the root directory of your project.
3. Edit the `migrationChecker.php` file and make sure to correctly enter the path to the `composer.json` and `installed.json` files in lines *55* and *56*.
4. Run the *Migration Checker*, which will analyze your files for issues.
5. Review the presented results, identifying code snippets that need to be updated.
6. Implement the recommended fixes following the displayed instructions.

The validator helps identify potential migration problems and offers suggestions for correction, but it's essential to remember that each application is unique and may have intricacies that cannot be automatically addressed. After making the suggested fixes, it's highly recommended to perform extensive testing on your application to ensure the proper functioning of the SDK.

![Validador de Migração](https://s3.amazonaws.com/gerencianet-pub-prod-1/printscreen/2023/08/23/guilherme.cota/0e29ad-%25guic.png)

## **License**
[MIT](LICENSE)
