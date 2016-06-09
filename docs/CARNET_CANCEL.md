### Canceling the carnet

Only `active` carnets can be canceled:

```php
$params = [
    'id' => 1002
];

try {
    $api = new Gerencianet($options);
    $response = $api->cancelCarnet($params, []);

    print_r($response);
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
