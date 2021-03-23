<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__ . '/../config.json');
$options = json_decode($file, true);
unset($options['pix_cert']);

$params = ['id' => 0];

$paymentToken = 'Insira_aqui_seu_paymentToken';

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '04267484171',
    'phone_number' => '5144916523',
    'email' => 'oldbuck@gerencianet.com.br',
    'birth' => '1990-01-15'
];

$billingAddress = [
    'street' => 'Av JK',
    'number' => 909,
    'neighborhood' => 'Bauxita',
    'zipcode' => '35400000',
    'city' => 'Ouro Preto',
    'state' => 'MG',
];

$body = [
    'payment' => [
        'credit_card' => [
            'installments' => 1,
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'customer' => $customer
        ]
    ]
];

try {
    $api = new Gerencianet($options);
    $response = $api->payCharge($params, $body);

    echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre>';
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
