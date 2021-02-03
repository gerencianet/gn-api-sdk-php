<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/pix/pixListReceived.php';

use Gerencianet\Endpoints;

class PixListReceivedTest extends \PHPUnit\Framework\TestCase
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
    public function pixReceivedList() {
        $method = 'get';
        $route = '/v2/pix?inicio=2020-11-22T16:01:35Z&fim=2021-01-22T16:01:35Z';

        $params = ['inicio' => '2020-11-22T16:01:35Z', 'fim' => '2021-01-22T16:01:35Z'];

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo(null));

        $endpoints = new Endpoints($this->options, $this->requester);

        $endpoints->pixReceivedList($params);
    }
}
