## Setting the payment method

There is only one way of giving sequence to a subscription. You need to use the customer's **credit card** to submit the payment.

As we know, the credit card information is confidential, so, you need to prepare your system to send this information in a securely way. See how to send it and receive the payment token in our official documentation. Here we show how to do the backend part:

```php
$paymentToken = 'payment_token';
$response = $apiGN->paySubscription()
                  ->subscriptionId($subscriptionId)
                  ->method('credit_card')
                  ->installments(3)
                  ->paymentToken($paymentToken)
                  ->billingAddress($address)
                  ->run()
                  ->response();
```

If everything went well, the response will come with the total value, installments number e the value of each installment:

```js
{
  "code": 200,
  "data": {
     "charge_id": 11000,
     "total": 36999,
     "payment": "credit_card",
     "installments": 3,
     "installment_value": 12333
  }
}
```

To know every installment value including interests for each brand, you can see [Getting the Payment Data](/docs/PAYMENT_DATA.md).

##### Payment tokens

A `payment_token` represents a credit card number at Gerencianet.

For testing purposes, you can go to your application playground in your Gerencianet's account. At the payment endpoint you'll see a button that generates one token for you. This payment token will point to a random test credit card number.

To know how to get a real payment token, you can see a [JS script](https://api.gerencianet.com.br/checkout/card) in our [official documentation](https://api.gerencianet.com.br/), or, if you need to use in a mobile appplication, we also have a [Android Guide](https://github.com/franciscotfmc/gn-api-sdk-android) and a [iOS Guide](https://github.com/thomazfeitoza/gn-api-sdk-ios).
