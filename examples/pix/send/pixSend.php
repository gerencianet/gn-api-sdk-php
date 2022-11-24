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

//To enable the pix/send endpoint it is necessary to contact
//with Gerencianet's Commercial team for a new contractual annex.

$params = [
	"idEnvio" => "0S000000000000000000000000000000000"
];

$body = [
	"valor" => "0.01",
	"pagador" => [
		"chave" => "",
		"infoPagador" => "order payment"
	],
	"favorecido" => [
		"chave" => ""
	]
];

try {
	$api = Gerencianet::getInstance($options);
	$response = $api->pixSend($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
