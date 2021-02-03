<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/oauth/generateAuth.php';

use Gerencianet\Endpoints;

class GenerateAuthTest extends \PHPUnit\Framework\TestCase
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
     * @test
     */
    public function authorize() {
        $method = 'post';
        $route = '/oauth/token';

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo(null));

        $endpoints = new Endpoints($this->options, $this->requester);
        $params = [];

        $endpoints->authorize($params);
    }
}
