# SDK GERENCIANET FOR PHP #
Sdk for Gerencianet Pagamentos' API.
For more informations about parameters and values, please refer to [Gerencianet](http://gerencianet.com.br) documentation.

**:warning: This module is under development and is based on the new API that Gerencianet is about to release. It won't work in production by now.**


[![Build Status](https://travis-ci.org/gerencianet/gn-api-sdk-php.svg)](https://travis-ci.org/gerencianet/gn-api-sdk-php)


## Installation ##
Require this package with [composer](https://getcomposer.org/):
```
$ composer require gerencianet/gerencianet-sdk-php
```
Or include it in your composer.json file:
```
...
"require": {
	"gerencianet/gerencianet-sdk-php": "1.*"
},
...
```

## Getting started ##
Require the module and namespaces:
```php
require __DIR__ . '/../sdk/vendor/autoload.php';

use Gerencianet\Gerencianet;
use Gerencianet\Models\Address;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Item;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\PostOfficeService;
use Gerencianet\Models\Repass;
use Gerencianet\Models\Shipping;
use Gerencianet\Models\GerencianetException;
```

If your system already has any class above, you can use PHP' namespaces
for conflict resolution as below:
```php
require __DIR__ . '/../sdk/vendor/autoload.php';

...
use Gerencianet\Models\Address as GerencianetAddress;
...
```

All code must be within a try-catch.
Gerencianet::error method can be used to print a JSON back to your frontend.
```php
try {
  /* code */
} catch(GerencianetException $e) {
  Gerencianet::error($e);
} catch(Exception $ex) {
  Gerencianet::error($ex);
}
```


### For development environment ###
Instantiate the module passing your apiKey, your apiSecret and the third parameter is used to change the environment to sandbox:
```php
$apiKey = 'your_client_id';
$apiSecret = 'your_client_secret';

$apiGN = new Gerencianet($apiKey, $apiSecret, true);
```

### For production environment ###
To change the environment to production, just set the third parameter to false:
```php
$apiKey = 'your_client_id';
$apiSecret = 'your_client_secret';

$apiGN = new Gerencianet($apiKey, $apiSecret, false);
```

## Running tests ##

To run tests install [PHPUnit](https://phpunit.de/getting-started.html) and run the following command:
```php
$ phpunit -c tests/config.xml tests
```

## Additional Documentation ##

- [Creating charges](/docs/CHARGE.md)
- [Associating a customer to a charge](/docs/CUSTOMER.md)
- [Setting the Payment Method](/docs/PAYMENT.md)
- [Notifications](/docs/NOTIFICATION.md)
- [Subscriptions](/docs/SUBSCRIPTION.md)
- [Detailing charges and subscriptions](/docs/DETAIL.md)
- [Marketplace](/docs/MARKETPLACE.md)
- [Getting Payment Data](/docs/PAYMENT_DATA.md)

## License ##
[MIT](LICENSE)
