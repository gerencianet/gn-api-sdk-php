<?php

namespace Gerencianet;

class Config
{
    /**
     * @var string Arquivo de configuração dos endpoints
     */
    private static $endpointsConfigfile = __DIR__ . '/config.json';

    /**
     * Altera arquivo de configuração
     * @param string $file Caminho do arquivo
     */
    public static function setEndpointsConfigFile($file)
    {
        self::$endpointsConfigfile = $file;
    }

    /**
     * Carrega as configurações do arquivo de endpoints
     * @param string $property Chave do parâmetro
     * @return mixed
     */
    public static function get($property)
    {
        $file = file_get_contents(self::$endpointsConfigfile);
        $config = json_decode($file, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erro ao carregar endpoints do arquivo");
        }
        
        if (isset($config[$property])) {
            return $config[$property];
        }

        return;
    }

    public static function options($options)
    {
        $conf = [];
        $conf['sandbox'] = isset($options['sandbox']) ? $options['sandbox'] : false;
        $conf['debug'] = isset($options['debug']) ? $options['debug'] : false;

        if (isset($options['client_id'])) {
            $conf['clientId'] = $options['client_id'];
        }
        if (isset($options['client_secret'])) {
            $conf['clientSecret'] = $options['client_secret'];
        }
        if (isset($options['timeout'])) {
            $conf['timeout'] = $options['timeout'];
        }

        if(Config::isPix($options))
            $conf['pixCert'] = $options['pix_cert'];

        if (isset($options['url'])) {
            $conf['baseUri'] = $options['url'];
        } else {
            $config = self::get('URL');
            $config = Config::isPix($options) ? $config['PIX'] : $config['DEFAULT'];
            $conf['baseUri'] = $config['production'];

            if ($conf['sandbox']) {
                $conf['baseUri'] = $config['sandbox'];
            }
        }

        if (isset($options['headers'])) {
            $conf['headers'] = $options['headers'];
        }

        return $conf;
    }

    public static function isPix($options)
    {
        return (isset($options['pix_cert']) && is_string($options['pix_cert']));
    }
}
