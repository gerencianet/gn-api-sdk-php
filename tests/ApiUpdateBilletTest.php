<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiUpdateBilletTest extends Base {

  public function testUpdateBillet() {
    $apiGN = self::createApiGN();

    $chargeId = 11000;

    $updateBillet = $apiGN->updateBillet()
                          ->chargeId($chargeId)
                          ->expireAt('2025-12-25');

    $this->assertNotEmpty($updateBillet);
    $this->assertEquals($updateBillet->getChargeId(), 11000);
    $this->assertEquals($updateBillet->getExpireAt(), '2025-12-25');
  }

  public function testExecutedUpdateBillet() {
    $apiGN = self::createApiGN();

    $chargeId = 11000;

    $updateBillet = $apiGN->updateBillet()
                          ->chargeId($chargeId)
                          ->expireAt('2025-12-25');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('updateBillet', 200)]);

    $clientGZ = $updateBillet->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $updateBillet->guzzleClient($clientGZ);

    $resp = $updateBillet->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
  }
}