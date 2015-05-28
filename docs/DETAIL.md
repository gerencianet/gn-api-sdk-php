## Detailing charges and subscriptions ##

To get information about a charge, you can use:
```php
$response = $apiGN->detailCharge()
                  ->chargeId($chargeId)
                  ->run()
                  ->response();
```

To get information about a subscription and its charges, you can use:
```php
$response = $apiGN->detailSubscription()
                  ->subscriptionId($subscriptionId)
                  ->run()
                  ->response();
```
