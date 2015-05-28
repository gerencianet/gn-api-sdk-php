## Getting payment data ##

If you ever need to get the total value for a charge, including rates and interests, as well as each installment value, even before the payment itself, you can.

Why would I need this?

Sometimes you need to check the total for making a discount, or simple to show a combobox with the installments for your users.

Here is the code:
```php
$response = $apiGN->getPaymentData()
                  ->type('mastercard')
                  ->value(10000)
                  ->run()
                  ->response();
```

And the response:

```js
{
  "code": 200,
  "data": {
    "rate": 150,
    "name": "mastercard",
    "installments": [
      {
        "installment": 1,
        "has_interest": false,
        "value": 10150,
        "currency": "101,50",
        "interest_percentage": 199
      },
      {
        "installment": 2,
        "has_interest": true,
        "value": 5279,
        "currency": "52,79",
        "interest_percentage": 199
      },
      {
        "installment": 3,
        "has_interest": true,
        "value": 3589,
        "currency": "35,89",
        "interest_percentage": 199
      },
      {
        "installment": 4,
        "has_interest": true,
        "value": 2746,
        "currency": "27,46",
        "interest_percentage": 199
      },
      {
        "installment": 5,
        "has_interest": true,
        "value": 2240,
        "currency": "22,40",
        "interest_percentage": 199
      },
      {
        "installment": 6,
        "has_interest": true,
        "value": 1904,
        "currency": "19,04",
        "interest_percentage": 199
      },
      {
        "installment": 7,
        "has_interest": true,
        "value": 1664,
        "currency": "16,64",
        "interest_percentage": 199
      },
      {
        "installment": 8,
        "has_interest": true,
        "value": 1485,
        "currency": "14,85",
        "interest_percentage": 199
      },
      {
        "installment": 9,
        "has_interest": true,
        "value": 1347,
        "currency": "13,47",
        "interest_percentage": 199
      },
      {
        "installment": 10,
        "has_interest": true,
        "value": 1236,
        "currency": "12,36",
        "interest_percentage": 199
      },
      {
        "installment": 11,
        "has_interest": true,
        "value": 1146,
        "currency": "11,46",
        "interest_percentage": 199
      },
      {
        "installment": 12,
        "has_interest": true,
        "value": 1072,
        "currency": "10,72",
        "interest_percentage": 199
      }
    ]
  }
}
```

Observe that the response comes with an installments array length of at most 12 positions, depending on brand. Each position matches one possible option of installment number, containing its value in currency and integer forms. Use it any way you need.

If you're curious about what would happen if you did this:

```php
$response = $apiGN->getPaymentData()
                  ->type('banking_billet')
                  ->value(10000)
                  ->run()
                  ->response();
```

Here it goes:

```js
{
  "code": 200,
  "data": {
    "total": 10150,
    "rate": 150,
    "currency": "101,50"
  }
}
```

When you use this payment method, the response comes with just the total value and the payment's method rate. The total value comes also parsed into currency, just in case.
