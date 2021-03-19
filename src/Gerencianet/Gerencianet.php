<?php

namespace Gerencianet;

class Gerencianet extends Endpoints
{
    public function __construct($options, $requester = null, $endpointsConfigFile = null)
    {
        if ($endpointsConfigFile) {
            Config::setEndpointsConfigFile($endpointsConfigFile);
        }

        parent::__construct($options, $requester);
    }
}
