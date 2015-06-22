<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiChargeTest extends Base {

  public function testCharge() {
    $charge = self::createCharge();

    $this->assertNotEmpty($charge);
    $this->assertNotEmpty($charge->getItems());
    $this->assertEquals(count($charge->getItems()), 3);
    $this->assertNotEmpty($charge->getShippings());
    $this->assertEquals(count($charge->getShippings()), 3);
    $this->assertNotEmpty($charge->getMetadata());
  }

  public function testExecuteCharge() {
    $charge = self::createCharge();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('charge', 200)]);

    $clientGZ = $charge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $charge->guzzleClient($clientGZ);

    $resp = $charge->run()
                   ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['charge_id'], 10000);
    $this->assertEquals($resp['data']['total'], 34725);
    $this->assertEquals($resp['data']['status'], 'new');
    $this->assertEquals($resp['data']['custom_id'], 'MyID');
    $this->assertEquals($resp['data']['created_at'], '2015-03-26 08:46:00');
  }
}