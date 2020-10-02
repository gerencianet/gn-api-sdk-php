### Resending billet

To resend the charge's billet, the charge must have a `waiting` status, and the payment method chosen must be `banking_billet`.

If the charge contemplates these requirements, you just have to provide the charge id and a email to resend the billet:

```php
$params = ['id' => 1000];

$body = [
    'email' => 'oldbuck@gerencianet.com.br'
];

try {
    $api = new Gerencianet($options);
    $response = $api->resendBillet($params, $body);

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
