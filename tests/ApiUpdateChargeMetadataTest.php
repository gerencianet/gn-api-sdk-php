<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiUpdateMetadataTest extends Base {

  public function testUpdateMetadata() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;
    $customId = "_001";

    $metadata = $apiGN->updateChargeMetadata()
                             ->chargeId($chargeId)
                             ->customId($customId)
                             ->notificationUrl('http://your.domain/your_notification_url');

    $this->assertNotEmpty($metadata);
    $this->assertEquals($metadata->getChargeId(), 10000);
    $this->assertEquals($metadata->getNotificationUrl(), 'http://your.domain/your_notification_url');
  }

  public function testExecuteUpdateMetadata() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;
    $customId = "_001";

    $metadata = $apiGN->updateChargeMetadata()
                             ->chargeId($chargeId)
                             ->customId($customId)
                             ->notificationUrl('http://your.domain/your_notification_url');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('updateMetadata', 200)]);

    $clientGZ = $metadata->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);
    $metadata->guzzleClient($clientGZ);

    $resp = $metadata->run()
                     ->response();

    $this->assertEquals($resp['code'], 200);
  }
}