<?php

require __DIR__.'/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__.'/../config.json');
$options = json_decode($file, true);

$params = ['id' => 0];

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