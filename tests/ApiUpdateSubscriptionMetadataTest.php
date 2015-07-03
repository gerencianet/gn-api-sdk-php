<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiUpdateSubscriptionMetadataTest extends Base {

  public function testUpdateMetadata() {
    $apiGN = self::createApiGN();

    $subscriptionId = 10000;
    $customId = "_001";

    $metadata = $apiGN->updateSubscriptionMetadata()
                      ->subscriptionId($subscriptionId)
                      ->customId($customId)
                      ->notificationUrl('http://your.domain/your_notification_url');

    $this->assertNotEmpty($metadata);
    $this->assertEquals($metadata->getSubscriptionId(), 10000);
    $this->assertEquals($metadata->getNotificationUrl(), 'http://your.domain/your_notification_url');
  }

  public function testExecuteUpdateMetadata() {
    $apiGN = self::createApiGN();

    $subscriptionId = 10000;
    $customId = "_001";

    $metadata = $apiGN->updateSubscriptionMetadata()
                      ->subscriptionId($subscriptionId)
                      ->customId($customId)
                      ->notificationUrl('http://your.domain/your_notification_url');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('subscriptionUpdateMetadata', 200)]);

    $clientGZ = $metadata->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);
    $metadata->guzzleClient($clientGZ);

    $resp = $metadata->run()
                     ->response();

    $this->assertEquals($resp['code'], 200);
  }
}