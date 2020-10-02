## Adding information to carnet's history

It is possible to add information to the history of a carnet. These informations will be listed when [detailing a carnet](/docs/CARNET_DETAIL.md).

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

$params = ['id' => 1002];

$body = ['description' => 'Info to be added to carnet history'];

try {
    $api = new Gerencianet($options);
    $response = $api->createCarnetHistory($params, $body);

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
