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

$customer = [
	"name" => "Gorbadoc Oldbuck",
	"cpf" => "94271564656",
	// "phone_number" => "5144916523",
	// "email" => "client_email@server.com.br",
	// "address" => [
	// 	"street" => "Avenida Juscelino Kubitschek",
	// 	"number" => "909",
	// 	"neighborhood" => "Bauxita",
	// 	"zipcode" => "35400000",
	// 	"city" => "Ouro Preto",
	// 	"complement" => "",
	// 	"state" => "MG"
	// ],
	// "juridical_person" => [
	// 	"corporate_name" => "Nome da razão social",
	// 	"cnpj" => "123456789000123"
	// ]
];

$configurations = [
	"fine" => 200,
	"interest" => 33
];

$discount = [
	"type" => 'currency',
	"value" => 599
];

$conditional_discount = [
	"type" => "percentage",
	"value" => 500,
	"until_date" => "2024-12-10"
];

$message = "This is a space\n of up to 80 characters\n to tell\n your client something";

$metadata = [
	"custom_id" => "Carnet 0001",
	"notification_url" => "https://your-domain.com.br/notification/"
];

$body = [
	"items" => $items,
	"customer" => $customer,
	"expire_at" => "2024-12-10",
	"message" => $message,
	"repeats" => 5,
	"split_items" => false,
	"configurations" => $configurations,
	"discount" => $discount,
	"conditional_discount" => $conditional_discount,
	"message" => $message,
	"metadata" => $metadata
];

try {
	$api = new Gerencianet($options);
	$response = $api->createCarnet($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
