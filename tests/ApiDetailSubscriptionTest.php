<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiDetailSubscriptionTest extends Base {

  public function testDetailSubscription() {
    $apiGN = self::createApiGN();

    $subscriptionId = 20000;

    $detailSubscription = $apiGN->detailSubscription()
                                ->subscriptionId($subscriptionId);

    $this->assertNotEmpty($detailSubscription);
    $this->assertEquals($detailSubscription->getSubscriptionId(), 20000);
  }

  public function testExecutedDetailSubscription() {
    $apiGN = self::createApiGN();

    $subscriptionId = 20000;

    $detailSubscription = $apiGN->detailSubscription()
                                ->subscriptionId($subscriptionId);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('detailSubscription', 200)]);

    $clientGZ = $detailSubscription->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $detailSubscription->guzzleClient($clientGZ);

    $resp = $detailSubscription->run()
                               ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['subscription']);
    $this->assertEquals($resp['subscription']['id'], 20000);
    $this->assertEquals($resp['subscription']['value'], 10000);
    $this->assertEquals($resp['subscription']['status'], 'new');
    $this->assertEquals($resp['subscription']['payment_method'], null);
    $this->assertEquals($resp['subscription']['interval'], 1);
    $this->assertEquals($resp['subscription']['repeats'], 2);
    $this->assertEquals($resp['subscription']['processed_amount'], 0);
    $this->assertEquals($resp['subscription']['created_at'], '2015-03-26 08:47:56');
    $this->assertNotEmpty($resp['subscription']['history']);
    $this->assertEquals(count($resp['subscription']['history']), 1);
    $this->assertEquals($resp['subscription']['history'][0]['charge_id'], 12000);
    $this->assertEquals($resp['subscription']['history'][0]['status'], 'new');
    $this->assertEquals($resp['subscription']['history'][0]['created_at'], '2015-03-26 08:47:56');
  }
}