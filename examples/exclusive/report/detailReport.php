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
	"id" => "00000000-0000-0000-0000-000000000000"
];

try {
	$api = Gerencianet::getInstance($options);
	$response = $api->detailReport($params);

	if (is_array($response)) {
		print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	} else {
		$output = fopen('php://output', 'w');
		fputs($output, $response);

		// Tell the browser it's going to be a csv file and download it
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=report_' . $params['id'] . '.csv');
	}
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
