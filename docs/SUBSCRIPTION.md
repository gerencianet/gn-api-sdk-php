## Subscriptions ##

To create a subscription, you have to create a plan that defines how the subscription will work.

The `repeats` parameter defines how many times the transaction will be repeated. If you don't pass it, the subscription will create charges indefinitely.

The `interval` parameter defines the interval, in months, that a charge has to be generated. The minimum value is 1, and the maximum is 24. So, define "1" if you want monthly creations for example.

Creating a plan:
```php
$plan = $apiGN->createPlan()
      		  ->name("My first plan")
      		  ->repeats(2)
      		  ->interval(1);
```


Creating a subscription:
```php
$response = $apiGN->createCharge()
                  ...
                  ->planId($plan["plan"]["id"])
                  ->run()
                  ->response();
```

Deleting a plan (works just for plans that hasn't a subscription associated):
```php
$apiGN->deletePlan()
	->planId($plan_id)	
      ->run();
```

Canceling a subscription:
```php
$response = $apiGN->cancelSubscription()
                  ->subscriptionId($subscriptionId)
                  ->isCustomer(true) // This is optional
                  ->run()
                  ->response();
```
