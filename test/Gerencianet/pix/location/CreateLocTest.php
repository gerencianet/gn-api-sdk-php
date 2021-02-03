<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/location/create.php';

use Gerencianet\Endpoints;

class CreateLocTest extends \PHPUnit\Framework\TestCase
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
    public function pixLocationCreate() {
        $method = 'post';
        $route = '/v2/loc';
        $body = [
            'tipoCob' => 'cob'
        ];

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo($body));

        $endpoints = new Endpoints($this->options, $this->requester);
        $params = [];

        $endpoints->pixLocationCreate($params, $body);
    }
}
