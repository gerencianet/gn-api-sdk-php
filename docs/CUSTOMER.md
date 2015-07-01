### Associating a customer to a charge

If you create a charge or a subscription without customers because you didn't know them or was planning to get their info afterwards, no need to panic. You can associate these customers like the following:

```php
$chargeId = ''; // The value returned by createCharge function
$customer = ''; // The instance of Customer class

$response = $apiGN->associateCustomer()
                  ->chargeId($chargeId)
                  ->customer($customer)
                  ->run()
                  ->response();
```

### Associating a customer to a subscription

```php
$subscriptionId = ''; // The value returned by createSubscription function
$customer = ''; // The instance of Customer class

$response = $apiGN->associateCustomer()
                  ->subscriptionId($subscriptionId)
                  ->customer($customer)
                  ->run()
                  ->response();
```

If everything went well, the return is just a response with code 200:

```js
{
  "code": 200
}
```