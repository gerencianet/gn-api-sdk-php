### Resending carnet parcel

To resend the carnet parcel, the parcel must have a `waiting` status.

If the parcel contemplates this requirement, you just have to provide the carnet id, the parcel number and a email to resend it:

```php
$params = [
    'id' => 1002,
    'parcel' => 2
];

$body = [
    'email' => 'oldbuck@gerencianet.com.br'
];

try {
    $api = new Gerencianet($options);
    $response = $api->resendParcel($params, $body);

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
