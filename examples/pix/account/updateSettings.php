<?php

require __DIR__.'/../../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__.'/../../config.json');
$options = json_decode($file, true);

try {
	$body = [		
        "pix" => [
            "receberSemChave" => true,
            "chaves" => [
                "isabelle@email.com" => [
                    "recebimento" => [
                        "txidObrigatorio" => false,
                        "qrCodeEstatico" => [
                            "recusarTodos" => false
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

	$api = Gerencianet::getInstance($options);
    $pix = $api->pixUpdateSettings($params, $body);

    echo json_encode(["code" => 204]);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);

    throw new Error($e->error);
} catch (Exception $e) {
    throw new Error($e->getMessage());
}
