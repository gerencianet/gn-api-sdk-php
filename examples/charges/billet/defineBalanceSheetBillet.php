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
	"title" => "Balance sheet demonstrative",
	"body" =>
	[
		0 =>
		[
			"header" => "Consumption  de Consumo",
			"tables" =>
			[
				0 =>
				[
					"rows" =>
					[
						0 =>
						[
							0 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "bold",
								"text" => "Expense example",
								"colspan" => 2,
							],
							1 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "bold",
								"text" => "Total posted",
								"colspan" => 2,
							],
						],
						1 =>
						[
							0 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "normal",
								"text" => "Installation",
								"colspan" => 2,
							],
							1 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "normal",
								"text" => "R$ 100,00",
								"colspan" => 2,
							],
						],
					],
				],
			],
		],
		1 =>
		[
			"header" => "Balance Sheet",
			"tables" =>
			[
				0 =>
				[
					"rows" =>
					[
						0 =>
						[
							0 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "normal",
								"text" => "Check in the Gerencianet documentation all the possible configurations of a balance sheet.",
								"colspan" => 4,
							],
						],
					],
				],
			],
		],
	],
];

try {
	$api = new Gerencianet($options);
	$response = $api->defineBalanceSheetBillet($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
