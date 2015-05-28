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
    $this->assertNotEmpty($resp['charge']);
    $this->assertEquals($resp['charge']['id'], 10000);
    $this->assertEquals($resp['charge']['total'], 34725);
    $this->assertEquals($resp['charge']['status'], 'new');
    $this->assertEquals($resp['charge']['custom_id'], 'MyID');
    $this->assertEquals($resp['charge']['created_at'], '2015-03-26');
  }

  public function testChargeToSubscription() {
    $charge = self::createChargeToSubscription();

    $this->assertNotEmpty($charge);
    $this->assertNotEmpty($charge->getItems());
    $this->assertEquals(count($charge->getItems()), 1);
    $this->assertNotEmpty($charge->getMetadata());
    $this->assertNotEmpty($charge->getSubscription());
  }

  public function testExecuteChargeToSubscription() {
    $charge = self::createChargeToSubscription();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('chargeToSubscription', 200)]);

    $clientGZ = $charge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $charge->guzzleClient($clientGZ);

    $resp = $charge->run()
                   ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['charge']);
    $this->assertEquals($resp['charge']['id'], 12000);
    $this->assertEquals($resp['charge']['subscription_id'], 20000);
    $this->assertEquals($resp['charge']['total'], 10000);
    $this->assertEquals($resp['charge']['status'], 'new');
    $this->assertEquals($resp['charge']['custom_id'], 'MyID');
    $this->assertEquals($resp['charge']['created_at'], '2015-03-26');
  }
}