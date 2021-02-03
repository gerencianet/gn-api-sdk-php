<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/charge/detail.php';

use Gerencianet\Endpoints;

class DetailTest extends \PHPUnit\Framework\TestCase
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
    public function pixDetailCharge() {
        $method = 'get';
        $txid = 'fc9a4366ff3d4964b5dbc6c91a8722d5';
        $route = '/v2/cob/'.$txid;

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo([]));

        $endpoints = new Endpoints($this->options, $this->requester);
        $params = ['txid' => 'fc9a4366ff3d4964b5dbc6c91a8722d5'];

        $endpoints->pixDetailCharge($params, []);
    }
}
