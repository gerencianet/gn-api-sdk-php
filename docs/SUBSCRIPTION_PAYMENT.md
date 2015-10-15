## Paying subscriptions

There is two ways of giving sequence to a subscription *banking billet* or *credit card*.

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


### 1. Banking billets

To submit the payment with banking billet, you just need define the customer and the expire at to first charge:

```php
$params = ['id' => 1000];

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523'
];

$body = [
    'payment' => [
        'banking_billet' => [
            'expire_at' => '2018-12-12',
            'customer' => $customer
        ]
    ]
];

try {
    $api = new Gerencianet($options);
    $subscription = $api->paySubscription($params, $body);

    print_r($subscription);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

If everything went well, the response will come with barcode, link to banking billet and the value oh each installment:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [subscription_id] => 6
            [status] => active
            [barcode] => 00190.00009 01523.894002 00065.309189 4 99280123005000
            [link] => https://visualizacao.gerencianet.com.br/emissao/99999_2578_ENASER3/A4XB-99999-65309-NEMDO2
            [expire_at] => 2018-12-12
            [plan] => Array
                (
                    [id] => 1000
                    [interval] => 2
                    [repeats] =>
                )
            [charge] => Array
                (
                    [id] => 1053
                    [status] => waiting
                )
            [total] => 5000
            [payment] => banking_billet
        )
)

```

### 2. Credit card

As we know, the credit card information is confidential, so, you need to prepare your system to send this information in a securely way. See how to send it and receive the payment token in our official documentation. Here we show how to do the backend part.


Then pay the subscription:

```php
$params = ['id' => 1000];

$paymentToken = 'payment_token';

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523',
    'email' => 'oldbuck@gerencianet.com.br',
    'birth' => '1977-01-15'
];

$billingAddress = [
    'street' => 'Av. JK',
    'number' => 909,
    'neighborhood' => 'Bauxita',
    'zipcode' => '35400000',
    'city' => 'Ouro Preto',
    'state' => 'MG',
];

$body = [
    'payment' => [
        'credit_card' => [
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'customer' => $customer
        ]
    ]
];

try {
    $api = new Gerencianet($options);
    $subscription = $api->paySubscription($params, $body);

    print_r($subscription);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```


If everything went well, the response will come with total value:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [subscription_id] => 6
            [status] => active
            [plan] => Array
                (
                    [id] => 1000
                    [interval] => 2
                    [repeats] =>
                )
            [charge] => Array
                (
                    [id] => 1053
                    [status] => waiting
                )
            [total] => 5000
            [payment] => credit_card
        )
)

```

To know every installment value including interests for each brand, you can see [Getting the Payment Data](/docs/PAYMENT_DATA.md).


##### Payment tokens

A `payment_token` represents a credit card number at Gerencianet.

For testing purposes, you can go to your application playground in your Gerencianet's account. At the payment endpoint you'll see a button that generates one token for you. This payment token will point to a random test credit card number.

When in production, it will depend if your project is a web app or a mobile app.

For web apps you should follow this [guide](https://api.gerencianet.com.br/checkout/card). It basically consists of copying/pasting a script tag in your checkout page.

For mobile apps you should use this [SDK for Android](https://github.com/gerencianet/gn-api-sdk-android) or this [SDK for iOS](https://github.com/gerencianet/gn-api-sdk-ios).
