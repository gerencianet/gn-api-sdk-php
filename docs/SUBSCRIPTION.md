## Subscriptions

To create a subscription, you have to create a plan that defines how the subscription will work.

The `repeats` parameter defines how many times the transaction will be repeated. If you don't pass it, the subscription will create charges indefinitely.

The `interval` parameter defines the interval, in months, that a charge has to be generated. The minimum value is 1, and the maximum is 24. So, define "1" if you want monthly creations for example.

### Creating and setting a plan to a subscription:
```php
$plan = $apiGN->createPlan()
      	  ->name("My first plan")
      	  ->repeats(2)
      	  ->interval(1);

$response = $apiGN->createSubscription()
                  ...
                  ->planId($plan["plan"]["id"])
                  ->run()
                  ->response();
```

### Setting customer to a subscription
`required`, but you can [set after creation](/docs/CUSTOMER.md)
```php
$customer = new Customer();
$customer->name('Gorbadoc Oldbuck')
         ->email('oldbuck@gerencianet.com.br')
         ->cpf('04267484171')
         ->birth('1977-01-15')
         ->phoneNumber('5044916523')

$response = $apiGN->createSubscription()
                  ...
                  ->customer($customer)
                  ->run()
                  ->response();
```

If the customer is juridical person, it's necessary to send corporate name e CNPJ (Brazilian document for juridical person). For this, you will do this:
```php
$juridicalPerson = new JuridicalPerson();
$juridicalPerson->corporateName('Fictional Company')
                ->cnpj('52841284000142');

$customer = new Customer();
$customer->...
         ->juridicalPerson($juridicalPerson); // optional.
```

### Deleting a plan (works just for plans that hasn't a subscription associated):
```php
$apiGN->deletePlan()
	    ->planId($plan_id)
      ->run();
```

### Canceling a subscription:

This will cancel any future transaction creations.
```php
$response = $apiGN->cancelSubscription()
                  ->subscriptionId($subscriptionId)
                  ->isCustomer(true) // This is optional
                  ->run()
                  ->response();
```
