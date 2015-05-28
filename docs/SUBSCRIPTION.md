## Subscriptions ##

To create a subscription, you just need to add some especific informations to the charge creation:
```php
$subscription = new Subscription();
$subscription->repeats(2)
             ->interval(1);

$response = $apiGN->createCharge()
                  ...
                  ->subscription($subscription)
                  ->run()
                  ->response();
```

Canceling a subscription:
```php
$response = $apiGN->cancelSubscription()
                  ->subscriptionId($subscriptionId)
                  ->isCustomer(true) // This is optional
                  ->run()
                  ->response();
```
