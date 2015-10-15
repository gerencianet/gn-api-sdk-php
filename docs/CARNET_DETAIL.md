## Detailing carnets

In order to retrieve carnets, just provide the carnet_id:

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

Then detail:


```php
$params = ['id' => 1000];

try {
    $api = new Gerencianet($options);
    $carnet = $api->detailCarnet($params, []);

    print_r($carnet);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

As response, you will receive all information about the carnet:

```php

Array
(
    [code] => 200
    [data] => Array
        (
            [carnet_id] => 4
            [status] => active
            [repeats] => 5
            [cover] =>
            [value] => 25000
            [split_items] => false
            [charges] => Array
                (
                    [0] => Array
                        (
                            [charge_id] => 1042
                            [status] => waiting
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65354-ENAMAL9
                            [barcode] => 00190.00009 01523.894002 00065.354185 6 84570000005000
                            [parcel] => 1
                        )

                    [1] => Array
                        (
                            [charge_id] => 1043
                            [status] => waiting
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65355-LELUA5
                            [barcode] => 00190.00009 01523.894002 00065.354185 5 84880000005000
                            [parcel] => 2
                        )

                    [2] => Array
                        (
                            [charge_id] => 1044
                            [status] => waiting
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65356-TANEM6
                            [barcode] => 00190.00009 01523.894002 00065.354185 2 85190000005000
                            [parcel] => 3
                        )

                    [3] => Array
                        (
                            [charge_id] => 1045
                            [status] => waiting
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65357-TADRO8
                            [barcode] => 00190.00009 01523.894002 00065.354185 5 85470000005000
                            [parcel] => 4
                        )

                    [4] => Array
                        (
                            [charge_id] => 1046
                            [status] => waiting
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65358-LUADA8
                            [barcode] => 00190.00009 01523.894002 00065.354185 4 85780000005000
                            [parcel] => 5
                        )

                )

            [created_at] => 2015-07-27 14:07:52
        )

)

```
