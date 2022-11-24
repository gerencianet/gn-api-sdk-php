<?php

if (file_exists($autoload = realpath(__DIR__ . "/../../../vendor/autoload.php"))) {
	require_once $autoload;
} else {
	print_r("Autoload not found or on path <code>$autoload</code>");
}

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

if (file_exists($options = realpath(__DIR__ . "/../../credentials/options.php"))) {
	require_once $options;
}

$options["headers"] = [
	"x-idempotency-key" => "dt9BHlyzrb5jrFNAdfEDVpHgiOmDbVqVxd"
];

$body = [
	"pagador" => [
		"idParticipante" => "00000000-0000-0000-0000-000000000000",
		"cpf" => "12345678909",
	],
	"favorecido" => [
		"contaBanco" => [
			"codigoBanco" => "364",
			"agencia" => "0001",
			"documento" => "11122233344",
			"nome" => "Gorbadoc Oldbuck",
			"conta" => "000000",
			"tipoConta" => "CACC"
		]
	],
	"valor" => "0.01",
	"infoPagador" => "Order 00001",
	"idProprio" => "Order_00001"
];

try {
	$api = Gerencianet::getInstance($options);
	$response = $api->ofStartPixPayment($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
