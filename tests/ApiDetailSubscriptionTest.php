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
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['subscription_id'], 20000);
    $this->assertEquals($resp['data']['value'], 10000);
    $this->assertEquals($resp['data']['status'], 'new');
    $this->assertEquals($resp['data']['payment_method'], null);
    $this->assertEquals($resp['data']['interval'], 1);
    $this->assertEquals($resp['data']['repeats'], 10);
    $this->assertEquals($resp['data']['processed_amount'], 0);
    $this->assertEquals($resp['data']['created_at'], '2015-03-26 08:57:56');
    $this->assertNotEmpty($resp['data']['history']);
    $this->assertEquals(count($resp['data']['history']), 1);
    $this->assertEquals($resp['data']['history'][0]['charge_id'], 12000);
    $this->assertEquals($resp['data']['history'][0]['status'], 'new');
    $this->assertEquals($resp['data']['history'][0]['created_at'], '2015-03-26 08:57:56');
  }
}