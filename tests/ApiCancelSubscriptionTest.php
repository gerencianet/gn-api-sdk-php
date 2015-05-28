<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiCancelSubscriptionTest extends Base {

  public function testCancelSubscription() {
    $apiGN = self::createApiGN();

    $subscriptionId = 20000;

    $cancelSubscription = $apiGN->cancelSubscription()
                                ->subscriptionId($subscriptionId)
                                ->isCustomer(true);

    $this->assertNotEmpty($cancelSubscription);
    $this->assertEquals($cancelSubscription->getSubscriptionId(), 20000);
    $this->assertEquals($cancelSubscription->getIsCustomer(), true);
  }

  public function testExecuteCancelSubscription() {
    $apiGN = self::createApiGN();

    $subscriptionId = 20000;

    $cancelSubscription = $apiGN->cancelSubscription()
                                ->subscriptionId($subscriptionId)
                                ->isCustomer(true);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('cancelSubscription', 200)]);

    $clientGZ = $cancelSubscription->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $cancelSubscription->guzzleClient($clientGZ);

    $resp = $cancelSubscription->run()
                               ->response();

    $this->assertEquals($resp['code'], 200);
  }
}