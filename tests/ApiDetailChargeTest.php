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
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['charge_id'], 10000);
    $this->assertEquals($resp['data']['total'], 34725);
    $this->assertEquals($resp['data']['status'], 'new');
    $this->assertEquals($resp['data']['custom_id'], 'MyID');
    $this->assertEquals($resp['data']['created_at'], '2015-03-26 08:46:00');
    $this->assertEquals($resp['data']['notification_url'], 'http://your_domain/your_notification_url');
    $this->assertNotEmpty($resp['data']['items']);
    $this->assertEquals(count($resp['data']['items']), 3);
    $this->assertEquals($resp['data']['items'][2]['name'], 'Item');
    $this->assertEquals($resp['data']['items'][2]['value'], 5000);
    $this->assertEquals($resp['data']['items'][2]['amount'], 2);
    $this->assertNotEmpty($resp['data']['items'][2]['marketplace']);
    $this->assertNotEmpty($resp['data']['items'][2]['marketplace']['repasses']);
    $this->assertEquals(count($resp['data']['items'][2]['marketplace']['repasses']), 2);
    $this->assertEquals($resp['data']['items'][2]['marketplace']['repasses'][0]['percentage'], 700);
    $this->assertEquals($resp['data']['items'][2]['marketplace']['repasses'][0]['payee_code'], 'payee_code_to_repass');
    $this->assertEquals($resp['data']['items'][2]['marketplace']['repasses'][1]['percentage'], 9300);
    $this->assertEquals($resp['data']['items'][2]['marketplace']['repasses'][1]['payee_code'], 'payee_code_my_repass');
    $this->assertNotEmpty($resp['data']['history']);
    $this->assertEquals(count($resp['data']['history']), 1);
    $this->assertEquals($resp['data']['history'][0]['status'], 'new');
    $this->assertEquals($resp['data']['history'][0]['created_at'], '2015-03-26 08:46:00');
    $this->assertNotEmpty($resp['data']['shippings']);
    $this->assertEquals(count($resp['data']['shippings']), 3);
    $this->assertEquals($resp['data']['shippings'][2]['name'], 'Shipping');
    $this->assertEquals($resp['data']['shippings'][2]['value'], 1575);
    $this->assertEquals($resp['data']['shippings'][2]['payee_code'], 'payee_code_to_repass');
    $this->assertNotEmpty($resp['data']['customer']);
    $this->assertEquals($resp['data']['customer']['name'], 'Gorbadoc Oldbuck');
    $this->assertEquals($resp['data']['customer']['email'], 'oldbuck@gerencianet.com.br');
    $this->assertEquals($resp['data']['customer']['cpf'], '04267484171');
    $this->assertEquals($resp['data']['customer']['birth'], '1977-01-15');
    $this->assertEquals($resp['data']['customer']['phone_number'], '5144916523');
    $this->assertNotEmpty($resp['data']['customer']['address']);
    $this->assertEquals($resp['data']['customer']['address']['street'], 'Street 3');
    $this->assertEquals($resp['data']['customer']['address']['number'], '10');
    $this->assertEquals($resp['data']['customer']['address']['complement'], null);
    $this->assertEquals($resp['data']['customer']['address']['neighborhood'], 'Bauxita');
    $this->assertEquals($resp['data']['customer']['address']['city'], 'Ouro Preto');
    $this->assertEquals($resp['data']['customer']['address']['state'], 'MG');
    $this->assertEquals($resp['data']['customer']['address']['zipcode'], '35400000');
    $this->assertNotEmpty($resp['data']['customer']['juridical_person']);
    $this->assertEquals($resp['data']['customer']['juridical_person']['corporate_name'], 'Fictional Company');
    $this->assertEquals($resp['data']['customer']['juridical_person']['cnpj'], '52841284000142');
  }
}