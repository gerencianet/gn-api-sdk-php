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

$body = [
	"pix" => [
		"receberSemChave" => true,
		"chaves" => [
			"355e4568-e89b-1243-a456-006655440001" => [
				"recebimento" => [
					"txidObrigatorio" => false,
					"qrCodeEstatico" => [
						"recusarTodos" => false
					],
					"webhook" => [
						"notificacao" => [
							"tarifa" => true
						]
					]
				]
			],
			"efa1db8c-735b-4898-92e0-a54daabe65e6" => [
				"recebimento" => [
					"txidObrigatorio" => false,
					"qrCodeEstatico" => [
						"recusarTodos" => false
					]
				]
			]
		]
	]
];

try {
	$api = Gerencianet::getInstance($options);
	$response = $api->updateAccountConfig($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
