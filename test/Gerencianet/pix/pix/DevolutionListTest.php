<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/pix/devolutionList.php';

use Gerencianet\Endpoints;

class DevolutionListTest extends \PHPUnit\Framework\TestCase
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
    public function pixDevolutionGet() {
        $method = 'get';
        $e2Id = '121212';
        $id = '34';
        $route = '/v2/pix/'.$e2Id.'/devolucao/'.$id;

        $params = [
            'e2eId' => '121212',
            'id'    => '34'
        ];

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo(null));

        $endpoints = new Endpoints($this->options, $this->requester);

        $endpoints->pixDevolutionGet($params);
    }
}
