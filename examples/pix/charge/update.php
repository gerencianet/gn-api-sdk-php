<?php

require __DIR__.'/../../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__.'/../../config.json');
$options = json_decode($file, true);

try {
	$params = ['txid' => '2hDbQgh341ukY60TiKeYhstfPCqZrjlEk5G'];

	$body = [
		"solicitacaoPagador" => "Cobrança alterada"
	];
	$api = Gerencianet::getInstance($options);
    $pix = $api->pixUpdateCharge($params, $body);

    print_r($pix);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}