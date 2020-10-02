### Resending the carnet

To resend the carnet, the carnet must have a `active` status.

If the carnet contemplates this requirement, you just have to provide the carnet id and a email to resend it:

```php
$params = [
    'id' => 1002
];

$body = [
    'email' => 'oldbuck@gerencianet.com.br'
];

try {
    $api = new Gerencianet($options);
    $response = $api->resendCarnet($params, $body);

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
