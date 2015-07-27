## Notifications

Instantiate the module:

```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = ['client_id' => 'client_id',
            'client_secret' => 'client_secret',
            'sandbox' => true];
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

Any changes that happen in the charges will trigger an event that notifies the `notification_url` provided at creation time (see [creating charges](https://github.com/gerencianet/gn-api-sdk-node/tree/master/docs/charges.md)).

It's also possible to set or change the `notification_url` for existing charges, see [updating informations](https://github.com/gerencianet/gn-api-sdk-node/tree/master/docs/charge-update.md).

Given that a charge has a valid `notification_url`, when the notification time comes you'll receive a post with a `token`. This token must be used to get the notification payload data.

The example below assumes that you're using receiving posts at php's $_POST variable.

```php
$params = ['token' => $_POST['notification']];

try {
    $api = new Gerencianet($options);
    $notification = $api->getNotification($params, []);

    print_r($notification);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

Response:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [charge_id] => 1039
            [total] => 5000
            [status] => new
            [custom_id] =>
            [created_at] => 2015-07-27 11:48:44
        )

)
```
