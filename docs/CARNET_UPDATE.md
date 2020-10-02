## Updating carnets

### Changing the metadata

You can update the `custom_id` or the `notification_url` of a carnet at any time you want.

Is important to know that it updates all the charges of the carnet. If you want to update only one, see [Updating charges](/docs/CHARGE_UPDATE.md).

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
Then update metadata:

```php
$params = ['id' => 1002];

$body = [
    'custom_id' => 'Carnet 0001',
    'notification_url' => 'http://domain.com/notification'
];

try {
    $api = new Gerencianet($options);
    $carnet = $api->updateCarnetMetadata($params, $body);

    print_r($carnet);
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

### Updating the expiration date of a parcel

To update or set an expiration date to a parcel, the parcel must have a `waiting` or 'unpaid' status. You just have to provide the `carnet_id`, the number of the parcel (`parcel`) and a new expiration date (`expire_at`):

```php
$params = ['id' => 1002, 'parcel' => 2];

$body = [
    'expire_at' => '2018-01-01'
];

try {
    $api = new Gerencianet($options);
    $carnet = $api->updateParcel($params, $body);

    print_r($carnet);
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
