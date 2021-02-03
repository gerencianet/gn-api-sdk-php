<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/webhooks/list.php';

use Gerencianet\Endpoints;

class ListWebhookTest extends \PHPUnit\Framework\TestCase
{
    private $options;
    private $requester;

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
    public function pixListWebhook() {
        $method = 'get';
        $route = '/v2/webhook?inicio=2020-10-22T16:01:35Z&fim=2020-10-23T16:01:35Z';

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo([]));

        $endpoints = new Endpoints($this->options, $this->requester);
        $params = ['inicio' => '2020-10-22T16:01:35Z',
                    'fim' => '2020-10-23T16:01:35Z'];

        $endpoints->pixListWebhook($params, []);
    }
}
