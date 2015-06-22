<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiCarnetTest extends Base {

  public function testCarnet() {
    $carnet = self::createCarnet();

    $this->assertNotEmpty($carnet);
    $this->assertNotEmpty($carnet->getItems());
    $this->assertEquals(count($carnet->getItems()), 3);
    $this->assertNotEmpty($carnet->getMetadata());
    $this->assertNotEmpty($carnet->getCustomer());
    $this->assertEquals($carnet->getExpireAt(), '2019-12-31');
    $this->assertEquals($carnet->getRepeats(), 3);
    $this->assertEquals($carnet->getSplitItems(), false);
    $this->assertNotEmpty($carnet->getPostOfficeService());
    $this->assertNotEmpty($carnet->getInstructions());

    $instructions = $carnet->getInstructions();
    $this->assertEquals(count($instructions), 4);
    $this->assertEquals($instructions[0], 'Instruction 1');
    $this->assertEquals($instructions[1], 'Instruction 2');
    $this->assertEquals($instructions[2], 'Instruction 3');
    $this->assertEquals($instructions[3], 'Instruction 4');

    $postOfficeService = $carnet->getPostOfficeService();
    $this->assertEquals($postOfficeService->getSendTo(), 'customer');
  }

  public function testExecuteCarnet() {
    $carnet = self::createCarnet();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('carnet', 200)]);

    $clientGZ = $carnet->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $carnet->guzzleClient($clientGZ);

    $resp = $carnet->run()
                   ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['carnet_id'], 3000);
    $this->assertEquals($resp['data']['cover'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CC-99999-99999-LOSI5/99999-99999-LOSI5');
    $this->assertNotEmpty($resp['data']['charges']);
    $this->assertEquals(count($resp['data']['charges']), 3);
    $this->assertEquals($resp['data']['charges'][0]['charge_id'], 1476);
    $this->assertEquals($resp['data']['charges'][0]['parcel'], '1');
    $this->assertEquals($resp['data']['charges'][0]['status'], 'waiting');
    $this->assertEquals($resp['data']['charges'][0]['value'], 10000);
    $this->assertEquals($resp['data']['charges'][0]['expire_at'], '2019-12-31');
    $this->assertEquals($resp['data']['charges'][0]['url'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-LOSI5');
    $this->assertEquals($resp['data']['charges'][0]['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
    $this->assertEquals($resp['data']['charges'][2]['charge_id'], 1478);
    $this->assertEquals($resp['data']['charges'][2]['parcel'], '3');
    $this->assertEquals($resp['data']['charges'][2]['status'], 'waiting');
    $this->assertEquals($resp['data']['charges'][2]['value'], 10000);
    $this->assertEquals($resp['data']['charges'][2]['expire_at'], '2020-02-28');
    $this->assertEquals($resp['data']['charges'][2]['url'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-SERMEH7');
    $this->assertEquals($resp['data']['charges'][2]['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
  }
}