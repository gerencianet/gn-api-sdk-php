<?php

namespace Gerencianet;

class Config
{
    public static function get($property)
    {
        $file = file_get_contents(__DIR__.'/config.json');
        $config = json_decode($file, true);

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

        if (isset($options['url'])) {
            $conf['baseUri'] = $options['url'];
        } else {
            $config = self::get('URL');
            $conf['baseUri'] = $config['production'];

            if ($conf['sandbox']) {
                $conf['baseUri'] = $config['sandbox'];
            }
        }

        return $conf;
    }
}
