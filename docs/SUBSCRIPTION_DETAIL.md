## Detailing subscriptions

To get information about a charge, you can use:
```php
$response = $apiGN->detailSubscription()
                  ->subscriptionId($subscriptionId)
                  ->run()
                  ->response();
```
