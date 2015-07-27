## Paying subscriptions

There is only one way of giving sequence to a subscription: you need to use the customer's *credit card* to submit the payment.

As we know, the credit card information is confidential, so, you need to prepare your system to send this information in a securely way. See how to send it and receive the paymnet token in our official documentation. Here we show how to do the backend part.

Instantiate the module:

```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = ['client_id' => 'client_id',
            'client_secret' => 'client_secret',
            'sandbox' => true];
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

Then pay the subscription:

```php
$params = ['id' => 1000];

$paymentToken = 'payment_token';

$customer = ['name' => 'Gorbadoc Oldbuck', 'cpf' => '04267484171' , 'phone_number' => '5144916523', 'email' => 'oldbuck@gerencianet.com.br',
'birth' => '1977-01-15', ];

$billingAddress = [
  'street' => 'Street 3',
  'number' => 10,
  'neighborhood' => 'Bauxita',
  'zipcode' => '35400000',
  'city' => 'Ouro Preto',
  'state' => 'MG',
];

$body = ['payment' => ['credit_card' => [
                                'billing_address' => $billingAddress,
                                'payment_token' => $paymentToken,
                                'customer' => $customer, ]]];

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


If everything went well, the response will come with total value, installments number and the value oh each installment:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [charge_id] => 1053
            [total] => 5000
            [payment] => credit_card
            [subscription_id] => 6
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
