<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiDetailChargeTest extends Base {

  public function testDetailCharge() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;

    $detailCharge = $apiGN->detailCharge()
                          ->chargeId($chargeId);

    $this->assertNotEmpty($detailCharge);
    $this->assertEquals($detailCharge->getChargeId(), 10000);
  }

  public function testExecutedDetailCharge() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;

    $detailCharge = $apiGN->detailCharge()
                          ->chargeId($chargeId);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('detailCharge', 200)]);

    $clientGZ = $detailCharge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $detailCharge->guzzleClient($clientGZ);

    $resp = $detailCharge->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['charge']);
    $this->assertEquals($resp['charge']['id'], 10000);
    $this->assertEquals($resp['charge']['total'], 34725);
    $this->assertEquals($resp['charge']['status'], 'new');
    $this->assertEquals($resp['charge']['custom_id'], 'MyID');
    $this->assertEquals($resp['charge']['created_at'], '2015-03-26');
    $this->assertEquals($resp['charge']['notification_url'], 'http://your_domain/your_notification_url');
    $this->assertNotEmpty($resp['charge']['items']);
    $this->assertEquals(count($resp['charge']['items']), 3);
    $this->assertEquals($resp['charge']['items'][2]['name'], 'Item');
    $this->assertEquals($resp['charge']['items'][2]['value'], 5000);
    $this->assertEquals($resp['charge']['items'][2]['amount'], 2);
    $this->assertNotEmpty($resp['charge']['items'][2]['marketplace']);
    $this->assertNotEmpty($resp['charge']['items'][2]['marketplace']['repasses']);
    $this->assertEquals(count($resp['charge']['items'][2]['marketplace']['repasses']), 2);
    $this->assertEquals($resp['charge']['items'][2]['marketplace']['repasses'][0]['percentage'], 700);
    $this->assertEquals($resp['charge']['items'][2]['marketplace']['repasses'][0]['payee_code'], 'payee_code_to_repass');
    $this->assertEquals($resp['charge']['items'][2]['marketplace']['repasses'][1]['percentage'], 9300);
    $this->assertEquals($resp['charge']['items'][2]['marketplace']['repasses'][1]['payee_code'], 'payee_code_my_repass');
    $this->assertNotEmpty($resp['charge']['history']);
    $this->assertEquals(count($resp['charge']['history']), 1);
    $this->assertEquals($resp['charge']['history'][0]['status'], 'new');
    $this->assertEquals($resp['charge']['history'][0]['created_at'], '2015-03-26 08:46:00');
    $this->assertNotEmpty($resp['charge']['shippings']);
    $this->assertEquals(count($resp['charge']['shippings']), 3);
    $this->assertEquals($resp['charge']['shippings'][2]['name'], 'Shipping');
    $this->assertEquals($resp['charge']['shippings'][2]['value'], 1575);
    $this->assertEquals($resp['charge']['shippings'][2]['payee_code'], 'payee_code_to_repass');
    $this->assertNotEmpty($resp['charge']['customer']);
    $this->assertEquals($resp['charge']['customer']['name'], 'Gorbadoc Oldbuck');
    $this->assertEquals($resp['charge']['customer']['email'], 'oldbuck@gerencianet.com.br');
    $this->assertEquals($resp['charge']['customer']['document'], '04267484171');
    $this->assertEquals($resp['charge']['customer']['birth'], '1977-01-15');
    $this->assertEquals($resp['charge']['customer']['phone_number'], '5044916523');
    $this->assertNotEmpty($resp['charge']['customer']['address']);
    $this->assertEquals($resp['charge']['customer']['address']['street'], 'Street 3');
    $this->assertEquals($resp['charge']['customer']['address']['number'], '10');
    $this->assertEquals($resp['charge']['customer']['address']['complement'], null);
    $this->assertEquals($resp['charge']['customer']['address']['neighborhood'], 'Bauxita');
    $this->assertEquals($resp['charge']['customer']['address']['city'], 'Ouro Preto');
    $this->assertEquals($resp['charge']['customer']['address']['state'], 'MG');
    $this->assertEquals($resp['charge']['customer']['address']['zipcode'], '35400000');
  }
}