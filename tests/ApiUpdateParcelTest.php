<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiUpdateParcelTest extends Base {

  public function testUpdateParcel() {
    $apiGN = self::createApiGN();

    $chargeId = 11000;

    $updateParcel = $apiGN->updateParcel()
                          ->chargeId($chargeId)
                          ->expireAt('2025-12-25');

    $this->assertNotEmpty($updateParcel);
    $this->assertEquals($updateParcel->getChargeId(), 11000);
    $this->assertEquals($updateParcel->getExpireAt(), '2025-12-25');
  }

  public function testExecutedUpdateParcel() {
    $apiGN = self::createApiGN();

    $chargeId = 11000;

    $updateParcel = $apiGN->updateParcel()
                          ->chargeId($chargeId)
                          ->expireAt('2025-12-25');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('updateParcel', 200)]);

    $clientGZ = $updateParcel->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);
    $updateParcel->guzzleClient($clientGZ);

    $resp = $updateParcel->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
  }
}