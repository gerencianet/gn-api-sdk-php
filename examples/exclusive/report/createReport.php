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
	"dataMovimento" => "2022-10-12",
	"tipoRegistros" => [
		"pixRecebido" => true,
		"pixEnviadoChave" => true,
		"pixEnviadoDadosBancarios" => true,
		"estornoPixEnviado" => true,
		"pixDevolucaoEnviada" => true,
		"pixDevolucaoRecebida" => true,
		"tarifaPixEnviado" => true,
		"tarifaPixRecebido" => true,
		"estornoTarifaPixEnviado" => true,
		"saldoDiaAnterior" => true,
		"saldoDia" => true,
		"transferenciaEnviada" => true,
		"transferenciaRecebida" => true,
		"estornoTransferenciaEnviada" => true,
		"tarifaTransferenciaEnviada" => true,
		"estornoTarifaTransferenciaEnviada" => true
	]
];

try {
	$api = Gerencianet::getInstance($options);
	$response = $api->createReport($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
