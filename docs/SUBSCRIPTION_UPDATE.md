## Updating subscriptions

### Changing the metadata

You can update the `custom_id` or the `notification_url` of a subscription at any time you want.

Is important to know that it updates all the charges of the subscription. If you want to update only one, see [Updating charges](/docs/CHARGE_UPDATE.md).

```php
require __DIR__.'/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__.'/../config.json');
$options = json_decode($file, true);

$params = ['id' => 1000];

$body = [
    'notification_url' => 'http://localhost',
    'custom_id' => 'Custom Subscription 0001'
];

try {
    $api = new Gerencianet($options);
    $subscription = $api->updateSubscriptionMetadata($params, $body);

    print_r($subscription);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

If everything goes well. the return will be:

```php
Array
(
    [code] => 200
)
```
