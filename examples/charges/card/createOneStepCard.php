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

$paymentToken = "insert_here_the_payment_token_referring_to_card_data";

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

$shippings = [
	[
		"name" => "Shipping to City",
		"value" => 1200
	]
];

$metadata = [
	"notification_url" => "https://your-domain.com.br/notification/"
];

$customer = [
	"name" => "Gorbadoc Oldbuck",
	"cpf" => "94271564656",
	"phone_number" => "5144916523",
	"email" => "oldbuck@gerencianet.com.br",
	"birth" => "1990-01-15"
];

$billingAddress = [
	"street" => "Av JK",
	"number" => 909,
	"neighborhood" => "Bauxita",
	"zipcode" => "35400000",
	"city" => "Ouro Preto",
	"state" => "MG"
];

$discount = [
	"type" => "currency",
	"value" => 599
];

$configurations = [
	"fine" => 200,
	"interest" => 33
];

$credit_card = [
	"customer" => $customer,
	"installments" => 1,
	"discount" => $discount,
	"billing_address" => $billingAddress,
	"payment_token" => $paymentToken,
	"message" => "This is a space\n of up to 80 characters\n to tell\n your client something"
];

$payment = [
	"credit_card" => $credit_card
];

$body = [
	"items" => $items,
	"shippings" => $shippings,
	"metadata" => $metadata,
	"payment" => $payment
];

try {
	$api = new Gerencianet($options);
	$response = $api->createOneStepCharge($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
