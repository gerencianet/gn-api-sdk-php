<?php

require __DIR__.'/../../../../vendor/autoload.php';

//Include Example-SDK
require __DIR__.'/../../../../examples/pix/charge/create.php';

use Gerencianet\Endpoints;

class CreateTest extends \PHPUnit\Framework\TestCase
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
    public function pixCreateCharge() {
        $method = 'put';
        $txid = 'fc9a4366ff3d4964b5dbc6c91a8722d5';
        $route = '/v2/cob/'.$txid;
        $body = [
            "calendario" => [
              "expiracao" => 3600
            ],
            "devedor" => [
              "cpf" => "12345678909",
              "nome" => "Francisco da Silva"
            ],
            "valor" => [
              "original" => "124.45"
            ],
            "chave" => $this->chave,
            "solicitacaoPagador" => "Cobrança dos serviços prestados.",
        ];

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                               $this->equalTo($route),
                               $this->equalTo($body));

        $endpoints = new Endpoints($this->options, $this->requester);
        $params = ['txid' => 'fc9a4366ff3d4964b5dbc6c91a8722d5'];

        $endpoints->pixCreateCharge($params, $body);
    }

    /**
     * @test API
     */
    public function pixGenerateQRCode() {
        $method = 'get';
        $id = '112233';
        $route = '/v2/loc/'.$id.'/qrcode';

        $this->requester->expects($this->once())
                        ->method('send')
                        ->with($this->equalTo($method),
                            $this->equalTo($route),
                            $this->equalTo([]));


        $params = ['id' => '112233'];

        $endpoints = new Endpoints($this->options, $this->requester);
        $endpoints->pixGenerateQRCode($params, []);
    }
}
