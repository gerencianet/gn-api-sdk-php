<?php

require __DIR__.'/../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__.'/../config.json');
$options = json_decode($file, true);

$body = [
	'name' => 'My plan',
	'interval' => 2,
	'repeats' => null
];

try {
    $api = new Gerencianet($options);
    $plan = $api->createPlan([], $body);

    print_r($plan);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
