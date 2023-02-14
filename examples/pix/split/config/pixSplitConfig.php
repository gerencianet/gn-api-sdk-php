<?php

if (file_exists($autoload = realpath(__DIR__ . "/../../../../vendor/autoload.php"))) {
	require_once $autoload;
} else {
	print_r("Autoload not found or on path <code>$autoload</code>");
}

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

if (file_exists($options = realpath(__DIR__ . "/../../../credentials/options.php"))) {
	require_once $options;
}

$body = [
	"descricao" => "Payment split - Plan 1",
	"lancamento" => [
		"imediato" => true
	],
	"split" => [
		"divisaoTarifa" => "assumir_total", //"assumir_total", "proporcional"
		"minhaParte" => [
			"tipo" => "porcentagem",
			"valor" => "80.00"
		],
		"repasses" => [
			[
				"tipo" => "porcentagem",
				"valor" => "12.00",
				"favorecido" => [
					"cpf" => "10567056635",
					"conta" => "2289441"
				]
			],
			[
				"tipo" => "porcentagem",
				"valor" => "8.00",
				"favorecido" => [
					"cpf" => "02273576633",
					"conta" => "2843552"
				]
			]
		]
	]
];

try {
	$api = Gerencianet::getInstance($options);
	$response = $api->pixSplitConfig($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
