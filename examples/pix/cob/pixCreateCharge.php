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
	"txid" => "00000000000000000000000000000000000" // Transaction unique identifier
];

$body = [
	"calendario" => [
		"expiracao" => 3600 // Charge lifetime, specified in seconds from creation date
	],
	"devedor" => [
		"cpf" => "12345678909",
		"nome" => "Francisco da Silva"
	],
	"valor" => [
		"original" => "0.01"
	],
	"chave" => "00000000-0000-0000-0000-000000000000", // Pix key registered in the authenticated Gerencianet account
	"solicitacaoPagador" => "Enter the order number or identifier.",
	"infoAdicionais" => [
		[
			"nome" => "Campo 1",
			"valor" => "Informação Adicional1"
		],
		[
			"nome" => "Campo 2",
			"valor" => "Informação Adicional2"
		]
	]
];

try {
	$api = Gerencianet::getInstance($options);
	$pix = $api->pixCreateCharge($params, $body);

	if ($pix["txid"]) {
		$params = [
			"id" => $pix["loc"]["id"]
		];

		$qrcode = $api->pixGenerateQRCode($params);

		echo "<b>Detalhes da cobrança:</b>";
		echo "<pre>" . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

		if ($options['sandbox'] === false) {
			echo "<b>Link responsivo:</b>";
			$urlPath = parse_url($pix['loc']["location"], PHP_URL_PATH);
			$locationPath = explode('/', trim($urlPath, '/'));
			$locationToken = end($locationPath);
			$responsiveLink = 'https://pix.gerencianet.com.br/cob/pagar/' . $locationToken;
			echo "<pre><a target='_blank' href='$responsiveLink'>$responsiveLink</a></pre>";
		}

		echo "<b>QR Code:</b>";
		echo "<pre>" . json_encode($qrcode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

		echo "<b>Imagem:</b><br>";
		echo "<img src='" . $qrcode["imagemQrcode"] . "' />";
	} else {
		echo "<pre>" . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
	}
} catch (GerencianetException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
} catch (Exception $e) {
	print_r($e->getMessage());
}
