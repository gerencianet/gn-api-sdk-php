## Setting the Payment Method ##

There are two ways of giving sequence to a charge. You can generate a **banking billet** so it is payable until its due date, or can use the customer's **credit card** to submit the payment.

### 1. Banking Billets

Setting banking billet as a charge's payment method is simple. You just have to provide the charge id and an expiration date (optional):

```php
$response = $apiGN->createPayment()
                  ->chargeId($chargeId)
                  ->method('banking_billet')
                  ->expireAt('2015-12-31') // This date is optional
                  ->run()
                  ->response();
```

If you don't set the `expire_at` attribute, the date will be today + 3 days.

You'll receive the payment info in the callback, such as the barcode and the banking billet link:

```js
{
  "code": 200,
  "data": {
    "charge_id": 11200,
    "total": 34875,
    "payment": "banking_billet",
    "barcode": "99999.99999 99999.999999 99999.999999 9 99999999999999",
    "link": "https://boleto.gerencianet.com.br/emissao/99999_9999_CORXI4/A4XB-99999-99999-BRABO1",
    "expire_at": "2015-05-21"
  }
}
```

### 2. Credit Card

If you need a faster payment confirmation, we recommend the credit card payment method. As we know, the credit card information is confidential, so, you need to prepare your system to send this information in a securely way. See how to send it and receive the payment token in our official documentation. Here we show how to do the backend part:

```php
$paymentToken = 'payment_token';
$response = $apiGN->createPayment()
                  ->chargeId($chargeId)
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

##### Payment tokens

A `payment_token` represents a credit card number at Gerencianet.

For testing purposes, you can go to your application playground in your Gerencianet's account. At the payment endpoint you'll see a button that generates one token for you. This payment token will point to a random test credit card number.

To know how to get a real payment token, you can see a [JS script](https://api.gerencianet.com.br/checkout/card) in our [official documentation](https://api.gerencianet.com.br/), or, if you need to use in a mobile appplication, we also have a [Android Guide](https://github.com/franciscotfmc/gn-api-sdk-android) and a [iOS Guide](https://github.com/thomazfeitoza/gn-api-sdk-ios).
