<?php

namespace Gerencianet;

use Gerencianet\Exception\AuthorizationException;

class ApiRequest
{
    private $auth;
    private $request;
    private $options;

    public function __construct(array $options = null)
    {
        $this->auth = new Auth($options);
        $this->request = new Request($options);
        $this->options = $options;
    }

    public function send($method, $route, $body)
    {
        if (!$this->auth->expires || $this->auth->expires <= time()) {
            $this->auth->authorize();
        }

        $composerData = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
        $requestTimeout = isset($this->options['timeout']) ? (float)$this->options['timeout'] : 30.0;
        $requestHeaders = [
            'Authorization' => 'Bearer ' . $this->auth->accessToken,
            'api-sdk' => 'php-' . $composerData['version']
        ];

        if (isset($this->options['partner_token']) || isset($this->options['partner-token'])) {
            $clientData['headers']['partner-token'] = isset($this->options['partner_token']) ? $this->options['partner_token'] : $this->options['partner-token'];
        }

        try {
            return $this->request->send($method, $route, [
                'json' => $body,
                'timeout' => $requestTimeout,
                'headers' => $requestHeaders
            ]);
        } catch (AuthorizationException $e) {
            $this->auth->authorize();

            return $this->request->send($method, $route, [
                'json' => $body,
                'timeout' => $requestTimeout,
                'headers' => $requestHeaders
            ]);
        }
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
