## Detailing charges

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

It's very simple to get details from a charge. You just need the id:

```php
$params = ['id' => 1000];

try {
    $api = new Gerencianet($options);
    $charge = $api->detailCharge($params, []);

    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

As response, you will receive all the information about the charge (including if it belongs to a subscription or carnet):

```php

Array
(
    [code] => 200
    [data] => Array
        (
            [charge_id] => 1000
            [total] => 5000
            [status] => canceled
            [custom_id] =>
            [created_at] => 2015-07-27 09:43:05
            [notification_url] =>
            [items] => Array
                (
                    [0] => Array
                        (
                            [name] => Item 1
                            [value] => 1000
                            [amount] => 1
                        )

                    [1] => Array
                        (
                            [name] => Item 2
                            [value] => 2000
                            [amount] => 2
                        )

                )

            [history] => Array
                (
                    [0] => Array
                        (
                            [message] => Cobrança criada
                            [created_at] => 2015-07-27 09:43:05
                        )

                    [1] => Array
                        (
                            [message] => Cobrança cancelada
                            [created_at] => 2015-07-27 10:22:43
                        )

                )

        )

)


```
