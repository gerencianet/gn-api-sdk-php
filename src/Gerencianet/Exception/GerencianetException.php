<?php

namespace Gerencianet\Exception;

use Exception;


class GerencianetException extends Exception
{
    private $error;
    private $errorDescription;

    public function __construct($exception, $code)
    {
        $error = $exception;

        if ($exception instanceof \GuzzleHttp\Psr7\Stream) {
            $error = $this->parseStream($exception);
        }

        $this->apiReturns($error, $code);   
    }

    private function apiReturns($error, $code){
        if (isset($error['message'])) {
            $message = $error['message'];

            $this->code = $code;
            $this->errorDescription = $error['message'];
        } else if (isset($error['error'])) { // error API Cobranças
            $message = isset($error['error_description']['message']) ? $error['error_description']['message'] : $error['error_description'];

            $this->code = $error['code'];
            $this->error = $error['error'];
            $this->errorDescription = $error['error_description'];
        } else if (isset($error['type'])) { // error API cobv e reports
            $this->code = $error['status'];
            $this->error = $error['title'] . ". " . $error['detail'];
            $this->errorDescription = $error['violacoes'];
        } else { // error API Pix
            $message = (isset($error['erros']['mensagem']) ?  $error['mensagem'] . ": " . $error['caminho'] . " " . $error['erros']['mensagem'] : $error['mensagem'] . ": " . $error['mensagem']);

            $this->code = $code;
            $this->error = (isset($error['erros']) ?  $error['mensagem'] : $error['nome']);
            $this->errorDescription = (isset($error['erros']) ?  $error['erros'] : $error['mensagem']);
        }

        parent::__construct($message, $this->code);
    }

    private function parseStream($stream)
    {
        $error = '';
        while (!$stream->eof()) {
            $error .= $stream->read(1024);
        }

        return json_decode($error, true);
    }

    public function __toString()
    {
        return 'Error ' . $this->code . ': ' . $this->message . "\n";
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
