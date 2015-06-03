<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPlanTest extends Base {

  public function testPlan() {
    $plan = self::createPlan();

    $this->assertNotEmpty($plan);
    $this->assertEquals($plan->getName(), 'Teste');
    $this->assertEquals($plan->getRepeats(), 10);
    $this->assertEquals($plan->getInterval(), 1);
  }

  public function testExecutePlan() {
    $charge = self::createPlan();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('plan', 200)]);

    $clientGZ = $charge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $charge->guzzleClient($clientGZ);

    $resp = $charge->run()
                   ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['plan_id'], 13000);
    $this->assertEquals($resp['data']['name'], 'Teste');
    $this->assertEquals($resp['data']['interval'], 1);
    $this->assertEquals($resp['data']['repeats'], 10);
    $this->assertEquals($resp['data']['created_at'], '2015-03-26 08:51:13');
  }
}