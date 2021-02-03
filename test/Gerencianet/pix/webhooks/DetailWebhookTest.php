<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/webhooks/detail.php';

use Gerencianet\Endpoints;

class DetailWebhookTest extends \PHPUnit\Framework\TestCase
{
    private $options;
    private $requester;

    //Chave Pix disponibilizada pela Gerencianet
    private $chave = '';

    protected function setUp(): void
    {
        $file = file_get_contents(__DIR__.'/../../../../examples/config.json');
        $this->options = json_decode($file, true);

        $this->requester = $this->getMockBuilder('ApiRequest')
                                ->setMethods(array('send'))
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->requester->method('send')
                        ->willReturn(true);
    }

    /**
     * @test API
     */
    public function pixGetWebhook() {
        $method = 'get';
        $route = '/v2/webhook/'.$this->chave;

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo([]));

        $endpoints = new Endpoints($this->options, $this->requester);
        $params = ['chave' => ''];

        $endpoints->pixGetWebhook($params, []);
    }
}
