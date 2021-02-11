<?php

require __DIR__.'/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = json_decode(__DIR__.'/../config.json', true);

$params = ['id' => 0];

try {
    $api = new Gerencianet($options);
    $charge = $api->cancelCharge($params, []);

    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
