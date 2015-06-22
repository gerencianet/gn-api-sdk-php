<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiDetailCarnetTest extends Base {

  public function testDetailCarnet() {
    $apiGN = self::createApiGN();

    $carnetId = 3000;

    $detailCarnet = $apiGN->detailCarnet()
                          ->carnetId($carnetId);

    $this->assertNotEmpty($detailCarnet);
    $this->assertEquals($detailCarnet->getCarnetId(), 3000);
  }

  public function testExecutedDetailCarnet() {
    $apiGN = self::createApiGN();

    $carnetId = 3000;

    $detailCarnet = $apiGN->detailCarnet()
                          ->carnetId($carnetId);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('detailCarnet', 200)]);

    $clientGZ = $detailCarnet->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $detailCarnet->guzzleClient($clientGZ);

    $resp = $detailCarnet->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['carnet_id'], 3000);
    $this->assertEquals($resp['data']['status'], 'active');
    $this->assertEquals($resp['data']['repeats'], 3);
    $this->assertEquals($resp['data']['cover'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CC-99999-99999-LOSI5/99999-99999-LOSI5');
    $this->assertEquals($resp['data']['value'], 30000);
    $this->assertNotEmpty($resp['data']['post_office_service']);
    $this->assertEquals($resp['data']['post_office_service']['send_to'], 'customer');
    $this->assertEquals($resp['data']['split_items'], false);
    $this->assertNotEmpty($resp['data']['charges']);
    $this->assertEquals(count($resp['data']['charges']), 3);
    $this->assertEquals($resp['data']['charges'][0]['charge_id'], 1476);
    $this->assertEquals($resp['data']['charges'][0]['status'], 'waiting');
    $this->assertEquals($resp['data']['charges'][0]['url'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-LOSI5');
    $this->assertEquals($resp['data']['charges'][0]['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
    $this->assertEquals($resp['data']['charges'][0]['parcel'], '1');
    $this->assertEquals($resp['data']['charges'][1]['charge_id'], 1477);
    $this->assertEquals($resp['data']['charges'][1]['status'], 'waiting');
    $this->assertEquals($resp['data']['charges'][1]['url'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-FOHI3');
    $this->assertEquals($resp['data']['charges'][1]['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
    $this->assertEquals($resp['data']['charges'][1]['parcel'], '2');
    $this->assertEquals($resp['data']['charges'][2]['charge_id'], 1478);
    $this->assertEquals($resp['data']['charges'][2]['status'], 'waiting');
    $this->assertEquals($resp['data']['charges'][2]['url'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-SERMEH7');
    $this->assertEquals($resp['data']['charges'][2]['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
    $this->assertEquals($resp['data']['charges'][2]['parcel'], '3');
    $this->assertEquals($resp['data']['created_at'], '2015-06-19 09:28:44');
  }
}