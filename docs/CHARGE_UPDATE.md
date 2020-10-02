## Updating charges

Instantiate the module:

```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = [
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'sandbox' => true
];

try {
    $api = new Gerencianet($options);

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
```

### Changing the metadata

You can update the `custom_id` or the `notification_url` of a charge at any time you want:

```php
$params = ['id' => 1000];

$body = [
    'custom_id' => 'Product 0001',
    'notification_url' => 'http://domain.com/notification'
];

try {
    $api = new Gerencianet($options);
    $charge = $api->updateChargeMetadata($params, $body);

    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

If everything goes well, the return will be:

```php
Array
(
    [code] => 200
)
```

### Updating the expiration date of a billet

To update or set a expiration date to a charge, the charge must have a `waiting` or `unpaid` status, and the payment method chosen must be `banking_billet`.

If the charge contemplates these requirements, you just have to provide the charge id and a new expiration date:

```php
$params = ['id' => 1000];

$body = [
    'expire_at' => '2016-01-01'
];

try {
    $api = new Gerencianet($options);
    $charge = $api->updateBillet($params, $body);

    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

If everything goes well, the return will be:

```php
Array
(
    [code] => 200
)
```
