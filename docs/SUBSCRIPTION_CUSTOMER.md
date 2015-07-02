## Associating a customer to a subscription

If you create a subscription without customers because you didn't know them or was planning to get their info afterwards, no need to panic. You can associate these customers like the following:

```php
$subscriptionId = ''; // The value returned by createSubscription function
$customer = ''; // The instance of Customer class

$response = $apiGN->associateSubscriptionCustomer()
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