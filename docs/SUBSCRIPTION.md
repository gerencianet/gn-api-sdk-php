## Creating subscriptions

If you ever have to recurrently charge your clients, you can create a different kind of charge, one that belongs to a subscription. This way, subsequent charges will be automatically created based on plan configuration and the charge value is charged in your customers' credit card, or the banking billet is generated and sent to costumer, accoding to plan’s configuration.

The plan configuration receive two params, that are repeats and interval:

The `repeats` parameter defines how many times the transaction will be repeated. If you don't pass it, the subscription will create charges indefinitely.

The `interval` parameter defines the interval, in months, that a charge has to be generated. The minimum value is 1, and the maximum is 24. So, define "1" if you want monthly creations for example.

It's worth to mention that this mechanics is triggered only if the customer commits the subscription. In other words, it takes effect when the customer pays the first charge.

At first, you need to to create a plan. Then, you create a charge passing a plan_id to generate a subscription. You can use the same plan_id whenever you want.

First instantiate the module:

```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = [
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'sandbox' => true
];

try {
    $api = new Gerencianet($options);

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
```

### Creating and setting a plan to a subscription:

```php
$body = [
    'name' => 'My plan',
    'interval' => 2,
    'repeats' => null
];

try {
    $api = new Gerencianet($options);
    $plan = $api->createPlan([], $body);

    print_r($plan);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

### Creating the subscription:

```php
$params = ['id' => 1000];

$items = [
    [
        'name' => 'Item 1',
        'amount' => 1,
        'value' => 1000
    ],
    [
        'name' => 'Item 2',
        'amount' => 2,
        'value' => 2000
    ]
];

$body = [
    'items' => $items
];

try {
    $api = new Gerencianet($options);
    $subscription = $api->createSubscription($params, $body);

    print_r($subscription);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

### Deleting a plan:
*(works just for plans that hasn't a subscription associated):*

```php
$params = ['id' => 1000];

try {
    $api = new Gerencianet($options);
    $plan = $api->deletePlan($params, []);

    print_r($plan);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

### Canceling subscriptions

You can cancel active subscriptions at any time:

```php
$params = ['id' => 1000];

try {
    $api = new Gerencianet($options);
    $subscription = $api->cancelSubscription($params, []);

    print_r($subscription);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```
If everything goes well, the return will be:

```php
Array
(
    [code] => 200
)
```

