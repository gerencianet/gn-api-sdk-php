<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__ . '/../../config.json');
$options = json_decode($file, true);

$options['headers'] = array(
    'x-skip-mtls-checking' => 'false',
);

$params = ['chave' => 'suachavepix@email.com.br'];
$body = ['webhookUrl' => 'https://seudominio.com.br/webhook/'];

try {
    $api = Gerencianet::getInstance($options);
    $pix = $api->pixConfigWebhook($params, $body);

    echo '<pre>' . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
