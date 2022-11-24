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

$items = [
	[
		"name" => "Product 1",
		"amount" => 1,
		"value" => 1000
	],
	[
		"name" => "Product 2",
		"amount" => 2,
		"value" => 2000
	]
];

$shippings = [ // Optional
	[
		"name" => "Shipping to City",
		"value" => 2000
	]
];

$body = [
	"items" => $items,
	"shippings" => $shippings
];

try {
	$api = new Gerencianet($options);
	$response = $api->createCharge($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
