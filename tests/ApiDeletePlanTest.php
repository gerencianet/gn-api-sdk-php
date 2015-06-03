<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiDeletePlanTest extends Base {

  public function testDeletePlan() {
    $plan = self::deletePlan();

    $this->assertNotEmpty($plan);
    $this->assertEquals($plan->getPlanId(), 13000);
  }

  public function testDeleteExecutePlan() {
    $charge = self::deletePlan();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('deletePlan', 200)]);

    $clientGZ = $charge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $charge->guzzleClient($clientGZ);

    $resp = $charge->run()
                   ->response();

    $this->assertEquals($resp['code'], 200);
  }
}