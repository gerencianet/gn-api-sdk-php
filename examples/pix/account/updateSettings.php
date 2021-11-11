<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__ . '/../../config.json');
$options = json_decode($file, true);

$body = [
    "pix" => [
        "receberSemChave" => true,
        "chaves" => [
            "355e4568-e89b-1243-a456-006655440001" => [
                "recebimento" => [
                    "txidObrigatorio" => false,
                    "qrCodeEstatico" => [
                        "recusarTodos" => false
                    ],
                    "webhook" => [
                        "notificacao" => [
                            "tarifa" => true
                        ]
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

try {
    $api = Gerencianet::getInstance($options);
    $pix = $api->pixUpdateSettings([], $body);

    echo '<pre>' . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}