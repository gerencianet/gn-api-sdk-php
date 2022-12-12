<?php

namespace Gerencianet;

use Exception;

class Endpoints
{
    private $requester;
    private $endpoints;
    private $methods;
    private static $instance;

    public function __construct($options, $requester = null)
    {
        $this->requester = $requester;
        $this->options = $options;

        $this->endpoints = Config::get('APIs');
    }

    public static function getInstance($options = null, $requester = null)
    {
        if (!isset(self::$instance)) {
            if (!isset($options)) {
                throw new Exception('Credentials Client_Id and Client_Secret not defined');
            }

            self::$instance = new self($options, $requester);
        }
        return self::$instance;
    }

    public function __call($method, $args)
    {
        $this->map($method);

        return $this->methods[$method]((isset($args[0]) ? $args[0] : []), (isset($args[1]) ? $args[1] : []));
    }

    public static function __callStatic($method, $args)
    {
        if (method_exists('\\Gerencianet\Utils', $method)) {
            return Utils::$method((isset($args[0]) ? $args[0] : null), (isset($args[1]) ? $args[1] : null));
        } else {
            throw new Exception("Nonexistent requested '$method' method");
        }
    }

    private function map($method)
    {
        if (!isset($this->endpoints['ENDPOINTS'])) {
            if (array_column($this->endpoints['PIX'], $method)) {
                $this->endpoints = $this->endpoints['PIX'];
                $this->options['api'] = 'PIX';
            } else if (array_column($this->endpoints['OPEN-FINANCE'], $method)) {
                $this->endpoints = $this->endpoints['OPEN-FINANCE'];
                $this->options['api'] = 'OPEN-FINANCE';
            } else if (array_column($this->endpoints['PAYMENTS'], $method)) {
                $this->endpoints = $this->endpoints['PAYMENTS'];
                $this->options['api'] = 'PAYMENTS';
            } else if (array_column($this->endpoints['OPENING-ACCOUNTS'], $method)) {
                $this->endpoints = $this->endpoints['OPENING-ACCOUNTS'];
                $this->options['api'] = 'OPENING-ACCOUNTS';
            } else if (array_column($this->endpoints['CHARGES'], $method)) {
                $this->endpoints = $this->endpoints['CHARGES'];
                $this->options['api'] = 'CHARGES';
            } else {
                throw new Exception("Nonexistent requested '$method' method");
            }
        }

        $this->methods = array_map(function ($endpoint) {
            return function ($params = [], $body = []) use ($endpoint) {
                $route = $this->getRoute($endpoint, $params);
                $query = $this->getQueryString($params);
                $route .= $query;

                $this->options['url'] = ($this->options['sandbox']) ? $this->endpoints['URL']['sandbox'] : $this->endpoints['URL']['production'];

                if ($this->options['url'] === null) {
                    throw new Exception($this->options['api'] . ' API endpoints works only in production environment');
                }

                if (!$this->requester) {
                    $this->requester = new ApiRequest($this->options);
                }

                return $this->requester->send($endpoint['method'], $route, $body);
            };
        }, $this->endpoints['ENDPOINTS']);
    }

    private function getRoute($endpoint, &$params)
    {
        $route = $endpoint['route'];
        $placeholders = '/\:(\w+)/im';
        preg_match_all($placeholders, $route, $matches);
        $variables = $matches[1];

        foreach ($variables as $value) {
            if (isset($params[$value])) {
                $route = str_replace(':' . $value, $params[$value], $route);
                unset($params[$value]);
            }
        }

        return $route;
    }

    private function getQueryString($params)
    {
        $keys = array_keys($params);
        $length = count($keys);

        if ($length == 0) {
            return '';
        }

        $reduce = function ($previous, $current) use ($keys, $params, $length) {
            $next = ($current == $length - 1) ? '' : '&';

            return $previous . $keys[$current] . '=' . (is_bool($params[$keys[$current]]) ? (((int) $params[$keys[$current]] === 1) ? 'true' : 'false')  : $params[$keys[$current]]) . $next;
        };

        return array_reduce(array_keys($keys), $reduce, '?');
    }
}
