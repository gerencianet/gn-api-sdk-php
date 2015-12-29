## Creating charges

Charges have one or more items. That's it.

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

### Adding items:
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

$body = [
    'items' => $items
];
```

### Adding shipping costs to a charge **(optional)**:

In order to be the most agnostic as possible about how the user handles shippings, the API just receives an array with the values. You can add as many as you want. Sometimes you'll want a shipping cost to be received by another person/account. In this case, you must provide the `payee_code`. The *Additional Shipping* in the example below will be passed on to the referenced account after the payment.

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

$shippings = [
    [
        'name' => 'My Shipping',
        'value' => 2000
    ],
    [
        'name' => 'Shipping to someone else',
        'value' => 1000,
        'payee_code' => 'GEZTAMJYHA3DAMBQGAYDAMRYGMZTGMBRGI'
    ]
];

$body = [
    'items' => $items,
    'shippings' => $shippings
];
```

### Charge `metadata` attribute:

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

$metadata = [
    'custom_id' => 'Product 0001',
    'notification_url' => 'http://my_domain.com/notification'
];

$body = [
    'items' => $items,
    'metadata' => $metadata
];
```

The `notification_url` property will be used for sending notifications once things happen with charges statuses, as when it's payment was approved, for example. More about notifications [here](/docs/NOTIFICATION.md). The `custom_id` property can be used to set your own reference to the charge.


### Finally, create the charge:

```php
try {
    $api = new Gerencianet($options);
    $charge = $api->createCharge([], $body);

    print_r($charge);
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
            [charge_id] => 1000
            [total] => 5000
            [status] => new
            [custom_id] =>
            [created_at] => 2015-07-27 11:48:44
        )

)
```
