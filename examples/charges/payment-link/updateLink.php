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

$params = [
	"id" => 0
];

$body = [
	"billet_discount" => 500,
	"conditional_discount" => [
		"type" => "percentage", // "percentage", "currency"
		"value" => 600,
		"until_date" => "2024-12-10"
	],
	"card_discount" => 200,
	"message" => "This is a space\n of up to 80 characters\n to tell\n your client something",
	"expire_at" => "2024-12-15",
	"request_delivery_address" => false,
	"payment_method" => "all" // "banking_billet", "credit_card", "all"
];

try {
	$api = new Gerencianet($options);
	$response = $api->updateChargeLink($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
