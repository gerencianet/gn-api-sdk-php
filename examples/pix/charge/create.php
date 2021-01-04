<?php

require __DIR__.'/../../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__.'/../../config.json');
$options = json_decode($file, true);

try {
	$params = ['txid' => Gerencianet::generateTxid($dynamic = true)];

	$body = [
		  "calendario" => [
		    "expiracao" => 3600
		  ],
		  "devedor" => [
		    "cpf" => "12345678909",
		    "nome" => "Francisco da Silva"
		  ],
		  "valor" => [
		    "original" => "124.45"
		  ],
		  "chave" => "498493029",
		  "solicitacaoPagador" => "Cobrança dos serviços prestados.",
		  "infoAdicionais" => [ 
			[
				"nome" => "Campo 1", // Nome do campo string (Nome) ≤ 50 characters
				"valor" => "Informação Adicional1 do PSP-Recebedor" // Dados do campo string (Valor) ≤ 200 characters
			],
			[
				"nome" => "Campo 2",
				"valor" => "Informação Adicional2 do PSP-Recebedor"
			]
		  ]
	];
	$api = Gerencianet::getInstance($options);
    $pix = $api->pixCreateCharge($params, $body);

    print_r($pix);
    if($pix['txid']) {
    	$dadosQRCode = [
    		'dynamic'   => false,
    		'oncePaid'  => true, //Pago uma única vez,
    		'freeValue' => true, //Valor livre
    		'merchant' => [
    			'name' => 'Minha Loja', //Nome do recebedor (sua loja)
    			'city' => 'Ouro Preto', //Cidade onde é efetuada a transação
    			'cep'  => '35400000' // Opcional
    		]
    	];
	    echo 'QR Code: <br />';
	    echo '<img src="'.Gerencianet::generateQrCode($pix, $dadosQRCode).'" />';
	}

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}