## Adding information to charge's history

It is possible to add information to the history of a charge. These informations will be listed when [detailing a charge](/docs/CHARGE_DETAIL.md).

The process to add information to history is shown below:


```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = [
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'sandbox' => true
];

$params = ['id' => 1000];

$body = ['description' => 'Info to be added to charges history'];

try {
    $api = new Gerencianet($options);
    $response = $api->createChargeHistory($params, $body);

    print_r($response);
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
