<?php
 
require __DIR__.'/../../vendor/autoload.php'; // caminho relacionado a SDK
 
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$file = file_get_contents(__DIR__.'/../config.json');
$options = json_decode($file, true);

$params = ['id' => 0];
 
try {
    $api = new Gerencianet($options);
    $charge = $api->settleCharge($params, []);
 
    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}