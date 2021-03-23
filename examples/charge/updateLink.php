<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__ . '/../config.json');
$options = json_decode($file, true);
unset($options['pix_cert']);

$params = ['id' => 0];

$body = [
    'billet_discount' => 0,
    'card_discount' => 0,
    'message' => '',
    'expire_at' => '2021-12-10',
    'request_delivery_address' => false,
    'payment_method' => 'all'
];

try {
    $api = new Gerencianet($options);
    $response = $api->updateChargeLink($params, $body);

    echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre>';
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
