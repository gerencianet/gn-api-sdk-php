## Creating charges with marketplace

What if your web store contains products from many different sellers from many different segments? The user can complete a single purchase with products from more than one seller, right? Here enters marketplace.

With some extra attributes, you can tell Gerencianet to pass on a percentage amount of the purchase total value to someone else.

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

Create the charge object including a marketplace object:

```php
$marketplace = [
    'repasses' => [
        [
            payee_code => "GEZTAMJYHA3DAMBQGAYDAMRYGMZTGM",
            percentage => 2500
        ],
        [
            payee_code => "AKSLJI3DAMBQGSKLJDYDAMRTGOPWKS",
            percentage => 2500
        ]
    ]
];

$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000,
        'marketplace' => $marketplace
    ]
];

$body = [
    'items' => $items
];
```

Create the charge:

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

The attribute `payee_code` identifies a Gerencianet account, just like in [creating charges with shippings](/docs/CHARGE.md). In order to get someone else's `payee_code` you need to ask the account owner. There is no other way. To visualize yours, log in your Gerencianet account and search for *Identificador de Conta* under *Dados Cadastrais*.

In the example above, there are two repasses, both of 25%, but each one for a different account, whereas the `payee_code` differs. The integrator account will receive, at the end, 50% of the total value. Disregarding the rates, the integrator account would receive R$5,00. The other two accounts would receive R$ 2,50 each.

The response is the same as usual:

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
