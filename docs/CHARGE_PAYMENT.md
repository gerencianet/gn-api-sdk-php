## Paying charges

There are two ways of giving sequence to a charge. You can generate a banking billet so it is payable until its due date, or can use the customer's credit card to submit the payment.

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

Setting banking billet as a charge's payment method is simple. You have to use `banking_billet` as the payment method and inform the `charge_id`.

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
    $charge = $api->payCharge($params, $body);

    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

You'll receive the payment info, such as the barcode and the billet link:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [charge_id] => 1000
            [total] => 5000
            [payment] => banking_billet
            [barcode] => 00190.00009 01523.894002 00065.309189 4 99280123005000
            [link] => https://visualizacao.gerencianet.com.br/emissao/99999_2578_ENASER3/A4XB-99999-65309-NEMDO2
            [expire_at] => 2018-12-12
        )

)
```

If you want the banking billet to have extra instructions, it's possible to send a maximum of 4 different instructions with a maximum of 90 caracters, just as follows:

```php
$params = ['id' => 1000];

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
    'payment' => [
        'banking_billet' => [
            'expire_at' => '2018-12-12',
            'customer' => $customer,
            'instructions' => $instructions
        ]
    ]
];

```

### 2. Credit card

The most common payment method is to use a credit card in order to make things happen faster. Paying a charge with a credit card in Gerencianet is as simples as generating a banking billet, as seen above.

The difference here is that we need to provide some extra information, as a `billing_address` and a `payment_token`. The former is used to make an anti-fraud analyze before accepting/appoving the payment, the latter identifies a credit card at Gerencianet, so that you don't need to bother about keeping track of credit card numbers. The `installments` attribute is self-explanatory.

We'll talk about getting payment tokens later. For now, let's take a look at the snipet that does the work we're aiming for:

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
            'installments' => 1,
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'customer' => $customer
        ]
    ]
];

try {
    $api = new Gerencianet($options);
    $charge = $api->payCharge($params, $body);

    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

If everything went well, the response will come with the total value, installments number and the value of each installment:

```php

Array
(
    [code] => 200
    [data] => Array
        (
            [charge_id] => 1000
            [total] => 5000
            [payment] => credit_card
            [installments] => 1
            [installment_value] => 5000
        )

)

```

##### Payment tokens

A `payment_token` represents a credit card number at Gerencianet.

For testing purposes, you can go to your application playground in your Gerencianet's account. At the payment endpoint you'll see a button that generates one token for you. This payment token will point to a random test credit card number.

When in production, it will depend if your project is a web app or a mobile app.

For web apps you should follow this [guide](https://docs.gerencianet.com.br/#!/charges/checkout/card). It basically consists of copying/pasting a script tag in your checkout page.

For mobile apps you should use this [SDK for Android](https://github.com/gerencianet/gn-api-sdk-android) or this [SDK for iOS](https://github.com/gerencianet/gn-api-sdk-ios).

### 3. Discount by payment method

It is possible to set discounts based on payment. You just need to add an `discount` attribute within `banking_billet` or `credit_card` tags.

The example below shows how to do this for credit card payments.

```php

$discount = [
  'type' => 'currency',
  'value'=> 1000
];

$body = [
    'payment' => [
        'credit_card' => [
            'installments' => 1,
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'customer' => $customer,
            'discount' => $discount
        ]
    ]
];

```
Discounts for banking billets works similar to credit cards. You just need to add the `discount` attribute.

The discount may be applied as percentage or with a previous calculated value.

The `type` property is used to specify how the discount will work. It may be set as *currency* or *percentage*.

The first will discount the amount specified in `value` property as *cents*, so, in the example above the amount paid by the customer will be equal `(Charge's value) - R$ 10,00`.

However, if the discount type is set to *percentage*, the amount will be `(Charge's value) - 10%`.
