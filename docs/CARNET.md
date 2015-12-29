## Creating carnet billets

Carnet is a payment method that generates a set of charges with the same payment information and customer in all of them.

To generate a carnet, you have as required: the items, a customer, the expiration date of the first charge and the number of repeats (or parcels).

If you want, you can also send some additional informations:

- The metadata information (like in the banking billet), with notification_url and/or custom_id;
- If the carnet must be send by post office service (choosing, inclusive, if you or your client must receive it);
- If the total value must be split among every charges or if each charge must have the value;
- The instructions to the carnet (At most 4 lines).

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

### Setting the required properties to a carnet:
`required`

```php
$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000
    ],
    [
        'name' => 'Item 2',
        'amount' => 2,
        'value' => 2000
    ]
];

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523'
];

$body = [
    'items' => $items,
    'customer' => $customer,
    'repeats' => 5,
    'expire_at' => '2020-12-02'
];
```

### Setting metadata to a carnet:
`optional`

```php
$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000
    ],
    [
        'name' => 'Item 2',
        'amount' => 2,
        'value' => 2000
    ]
];

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523'
];

$metadata = [
    'custom_id' => 'Product 0001',
    'notification_url' => 'http://domain.com/notification'
];

$body = [
    'items' => $items,
    'customer' => $customer,
    'repeats' => 5,
    'expire_at' => '2020-12-02',
    'metadata' => $metadata
];

```

The `notification_url` property will be used for notifications once things happen with charges status, as when it's payment was approved, for example. More about notifications [here](/docs/NOTIFICATION.md). The `custom_id` property can be used to set your own reference to the carnet.


### Setting post office service information:
`optional`

If you want the carnet to arrive at your house or at your client's house, you can count on Gerencianet's post office service. Just send an extra attribute:

```php
$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000
    ],
    [
        'name' => 'Item 2',
        'amount' => 2,
        'value' => 2000
    ]
];

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523'
];

$postOfficeService = [
    'send_to' => 'customer'
];

$body = [
    'items' => $items,
    'customer' => $customer,
    'repeats' => 5,
    'expire_at' => '2020-12-02',
    'post_office_service' => $postOfficeService
];
```

If `send_to` is set to *customer*, the carnet arrives at you customer's. If it is set to *seller*, just wait for it to arrive at your place!


### Setting the split items information
`optional`

By default, each parcel has the total value of the carnet as its value. If you want to divide the total value of the carnet by all the parcels, set the `split_items` property to *true*.

```php
$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000
    ],
    [
        'name' => 'Item 2',
        'amount' => 2,
        'value' => 2000]
    ];

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523'
];

$body = [
    'items' => $items,
    'customer' => $customer,
    'repeats' => 5,
    'expire_at' => '2020-12-02',
    'splite_items' => true
];
```

### Setting instructions
`optional`

If you want the carnet billet to have extra instructions, it's possible to send a maximum of 4 different instructions with a maximum of 90 caracters, just as follows:

```php
$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000
    ],
    [
        'name' => 'Item 2',
        'amount' => 2,
        'value' => 2000]
    ];

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523'
];

$instructions = [
    'Pay only with money',
    'Do not pay with gold'
];

$body = [
    'items' => $items,
    'customer' => $customer,
    'repeats' => 5,
    'expire_at' => '2020-12-02',
    'instructions' => $instructions
];
```

### Finally, create the carnet:

```php
try {
    $api = new Gerencianet($options);
    $carnet = $api->createCarnet([], $body);

    print_r($carnet);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

Check out the response:

```php

Array
(
    [code] => 200
    [data] => Array
        (
            [carnet_id] => 1002
            [charges] => Array
                (
                    [0] => Array
                        (
                            [charge_id] => 1042
                            [parcel] => 1
                            [status] => waiting
                            [value] => 5000
                            [expire_at] => 2020-12-02
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65354-ENAMAL9
                            [barcode] => 00190.00009 01523.894002 00065.354185 6 84570000005000
                        )

                    [1] => Array
                        (
                            [charge_id] => 1043
                            [parcel] => 2
                            [status] => waiting
                            [value] => 5000
                            [expire_at] => 2021-01-02
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65355-LELUA5
                            [barcode] => 00190.00009 01523.894002 00065.354185 5 84880000005000
                        )

                    [2] => Array
                        (
                            [charge_id] => 1044
                            [parcel] => 3
                            [status] => waiting
                            [value] => 5000
                            [expire_at] => 2021-02-02
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65356-TANEM6
                            [barcode] => 00190.00009 01523.894002 00065.354185 2 85190000005000
                        )

                    [3] => Array
                        (
                            [charge_id] => 1045
                            [parcel] => 4
                            [status] => waiting
                            [value] => 5000
                            [expire_at] => 2021-03-02
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65357-TADRO8
                            [barcode] => 00190.00009 01523.894002 00065.354185 5 85470000005000
                        )

                    [4] => Array
                        (
                            [charge_id] => 1046
                            [parcel] => 5
                            [status] => waiting
                            [value] => 5000
                            [expire_at] => 2021-04-02
                            [url] => https://visualizacao.gerencianet.com.br/emissao/28333_2579_NEMLUA0/A4CL-28333-65354-ENAMAL9/28333-65358-LUADA8
                            [barcode] => 00190.00009 01523.894002 00065.354185 4 85780000005000
                        )

                )

        )

)

```

Notice that, as the `repeats` were set to 5, the output contains 5 charges with `waiting` status. The value of each charge is the sum of the items values, because the `split_items` property was set to *false*. Also notice that `expire_at` increases monthly.
