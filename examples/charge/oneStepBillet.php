<?php
require __DIR__ . '/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__ . '/../config.json');
$options = json_decode($file, true);
unset($options['pix_cert']);

$item_1 = [
    'name' => 'Gorbadoc Oldbuck',
    'amount' => 1,
    'value' => 3000
];

$items = [
    $item_1
];

$metadata = array('notification_url' => 'https://meuip.in/xxxxx.php');

$customer = [
    'name' => 'Gorbadoc Oldbuck',
    'cpf' => '94271564656',
    'phone_number' => '5144916523'
];

$discount = [
    'type' => 'currency',
    'value' => 599
];

$configurations = [
    'fine' => 200,
    'interest' => 33
];

$conditional_discount = [
    'type' => 'percentage',
    'value' => 500,
    'until_date' => '2021-12-08'
];

$bankingBillet = [
    'expire_at' => '2021-12-10',
    'message' => 'teste\nteste\nteste\nteste',
    'customer' => $customer,
    'discount' => $discount,
    'conditional_discount' => $conditional_discount
];

$payment = [
    'banking_billet' => $bankingBillet
];

$body = [
    'items' => $items,
    'metadata' => $metadata,
    'payment' => $payment
];

try {
    $api = new Gerencianet($options);
    $response = $api->oneStep([], $body);

    echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
