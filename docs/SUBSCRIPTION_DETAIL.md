## Detailing subscriptions

Works just like the last example, but here you pass the subscription id:

```php
$params = ['id' => 0];

try {
    $api = new Gerencianet($options);
    $subscription = $api->detailSubscription($params, []);

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
    [data] => Array
        (
            [subscription_id] => 4
            [value] => 5000
            [status] => active
            [payment_method] => credit_card
            [next_execution] =>
            [next_expire_at] =>
            [plan] => Array
                (
                    [plan_id] => 1
                    [name] => Master of fear
                    [interval] => 12
                    [repeats] => 2
                )

            [occurrences] => 1
            [created_at] => 2015-07-27 10:51:12
            [history] => Array
                (
                    [0] => Array
                        (
                            [charge_id] => 1034
                            [status] => waiting
                            [created_at] => 2015-07-27 10:51:12
                        )

                )

        )

)
```

Note that if you [detail a charge](/docs/CHARGE_DETAIL.md) that belongs to a subscription, the response will have a `subscription_id`.
