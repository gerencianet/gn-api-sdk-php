<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/pix/createDevolution.php';

use Gerencianet\Endpoints;

class CreateDevolutionTest extends \PHPUnit\Framework\TestCase
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
    public function pixDevolution() {
        $method = 'put';
        $e2Id = '121212';
        $id = '34';
        $route = '/v2/pix/'.$e2Id.'/devolucao/'.$id;


        $body = [
            'valor' => '0.01'
        ];
        $params = [
            'e2eId' => '121212',
            'id'    => '34'
        ];

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo($body));

        $endpoints = new Endpoints($this->options, $this->requester);

        $endpoints->pixDevolution($params, $body);
    }
}
