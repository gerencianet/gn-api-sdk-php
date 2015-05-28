<?php

require_once __DIR__.'/Base.php';

class SubscriptionTest extends Base {

  public function testSubscription() {
    $subscription = self::createSubscription();

    $this->assertNotEmpty($subscription);
    $this->assertEquals($subscription->getRepeats(), 2);
    $this->assertEquals($subscription->getInterval(), 1);
  }
}