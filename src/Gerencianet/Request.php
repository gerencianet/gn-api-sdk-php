<?php

namespace Gerencianet;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Exception\AuthorizationException;

class Request
{
    private $client;
    private $config;
    private $certified_path;

    public function __construct(array $options = null)
    {
        $this->config = Config::options($options);
        $composerData = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
        $this->certified_path = isset($options['certified_path']) ? $options['certified_path'] : null;

        $clientData = [
            'debug' => $this->config['debug'],
            'base_uri' => $this->config['baseUri'],
            'headers' => [
                'Content-Type' => 'application/json',
                'api-sdk' => 'php-' . $composerData['version']
            ]
        ];

        if (isset($options['partner_token'])) {
            $clientData['headers']['partner-token'] = $options['partner_token'];
        }

        $this->client = new Client($clientData);
    }

    public function send($method, $route, $requestOptions)
    {
        try {
            if ($this->certified_path) {
                $this->client->setDefaultOption('verify', $this->certified_path);
            }

            if (isset($this->config['pixCert'])) {
                if (file_exists(realpath($this->config['pixCert']))) {
                    $requestOptions['cert'] = realpath($this->config['pixCert']);

                    $certinfo = openssl_x509_parse(file_get_contents($requestOptions['cert']));
                    $today = date("Y-m-d H:i:s");
                    $validTo = date('Y-m-d H:i:s', $certinfo['validTo_time_t']);

                    if ($validTo <= $today) {
                        throw new GerencianetException(['nome' => 'forbidden', 'mensagem' => 'Authentication certificate expired on ' . $validTo], 403);
                    }
                } else {
                    throw new GerencianetException(['nome' => 'forbidden', 'mensagem' => 'Certificate not found'], 403);
                }
            }

            // Custom header data
            if (isset($this->config['headers'])) {
                foreach ($this->config['headers'] as $key => $value) {
                    $requestOptions['headers'][$key] = $value;
                }
            }

            $response = $this->client->request($method, $route, $requestOptions);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            if (is_array(json_decode($e->getResponse()->getBody(), true)) && $e->getResponse()->getStatusCode() != 401) {
                throw new GerencianetException(json_decode($e->getResponse()->getBody(), true), $e->getResponse()->getStatusCode());
            } else {
                throw new AuthorizationException(
                    $e->getResponse()->getStatusCode(),
                    $e->getResponse()->getReasonPhrase(),
                    $e->getResponse()->getBody()
                );
            }
        } catch (ServerException $se) {
            throw new GerencianetException($se->getResponse()->getBody(), $se->getResponse()->getStatusCode());
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
