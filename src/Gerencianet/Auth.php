<?php

namespace Gerencianet;

use Exception;

class Auth
{
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $tokenType;
    private $expires;
    private $config;
    private $options;
    private $request;
    private $certificate;

    public function __construct($options)
    {
        $this->options = $options;
        $this->config = Config::options($options);

        if (
            !isset($this->config['clientId']) ||
            !isset($this->config['clientSecret'])
        ) {
            throw new Exception('Client_Id or Client_Secret not found');
        }

        $this->request = new Request($options);

        $this->clientId = $this->config['clientId'];
        $this->clientSecret = $this->config['clientSecret'];
        $this->certificate = (isset($this->config['certificate'])) ? $this->config['certificate'] : ((isset($this->config['pix_cert'])) ? $this->config['pix_cert'] : null);
    }

    public function authorize()
    {
        $endpoints = Config::get($this->options['api']);
        $requestTimeout = isset($this->options['timeout']) ? (float)$this->options['timeout'] : 30.0;

        $requestOptions = [
            'auth' => [$this->clientId, $this->clientSecret],
            'json' => ['grant_type' => 'client_credentials'], 'timeout' => $requestTimeout
        ];

        $response = $this->request
            ->send(
                $endpoints['ENDPOINTS']['authorize']['method'],
                $endpoints['ENDPOINTS']['authorize']['route'],
                $requestOptions
            );

        $this->accessToken = $response['access_token'];
        $this->expires = time() + $response['expires_in'];
        $this->tokenType = $response['token_type'];
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
