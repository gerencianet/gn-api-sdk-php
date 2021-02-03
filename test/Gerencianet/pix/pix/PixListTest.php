<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/pix/pixList.php';

use Gerencianet\Endpoints;

class PixListTest extends \PHPUnit\Framework\TestCase
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
    public function pixSendList() {
        $method = 'get';
        $e2eId = '121212';
        $route = '/v2/pix/'.$e2eId;

        $params = [
            'e2eId' => '121212'
        ];

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo(null));

        $endpoints = new Endpoints($this->options, $this->requester);

        $endpoints->pixSendList($params);
    }
}
