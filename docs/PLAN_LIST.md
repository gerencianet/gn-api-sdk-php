## Listing plans

Listing plans is pretty simple. There are no required parameters for this, although you can use special query parameters can be used to filter your search.
By default, the search will bring back 20 registers and always start from offset 0.
The example below shows how to use it:

```php
$params = [
    'name' => 'My plan',
    'limit' => 20,
    'offset' => 0
];

try {
    $api = new Gerencianet($options);
    $plans = $api->getPlans($params, []);

    print_r($plans);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
```

If the filters are correct, the response will be an array like this:
```php

Array
(
    [code] => 200
    [data] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [name] => My plan
                    [interval] => 12
                    [repeats] => 2
                    [created_at] => 2015-07-22T12:33:06.000Z
                    [updated_at] => 2015-07-22T12:33:06.000Z
                )
            [1] => Array
                (
                    [id] => 2
                    [name] => My other plan
                    [interval] => 1
                    [repeats] => 12
                    [created_at] => 2014-12-22T12:33:06.000Z
                    [updated_at] => 2014-12-22T12:33:06.000Z
                )

        )

)
```
