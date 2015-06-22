<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiSubscriptionTest extends Base {

  public function testSubscription() {
    $subscription = self::createSubscription();

    $this->assertNotEmpty($subscription);
    $this->assertNotEmpty($subscription->getItems());
    $this->assertEquals(count($subscription->getItems()), 1);
    $this->assertNotEmpty($subscription->getMetadata());
    $this->assertNotEmpty($subscription->getPlanId());
  }

  public function testExecuteSubscription() {
    $subscription = self::createSubscription();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('subscription', 200)]);

    $clientGZ = $subscription->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $subscription->guzzleClient($clientGZ);

    $resp = $subscription->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['charge_id'], 12000);
    $this->assertEquals($resp['data']['subscription_id'], 20000);
    $this->assertEquals($resp['data']['total'], 10000);
    $this->assertEquals($resp['data']['status'], 'new');
    $this->assertEquals($resp['data']['custom_id'], 'MyID');
    $this->assertEquals($resp['data']['created_at'], '2015-03-26 08:57:56');
  }
}