<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiNotificationUrlTest extends Base {

  public function testUpdateNotificationUrl() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;

    $notificationUrl = $apiGN->updateNotificationUrl()
                             ->chargeId($chargeId)
                             ->notificationUrl('http://your_domain/your_notification_url');

    $this->assertNotEmpty($notificationUrl);
    $this->assertEquals($notificationUrl->getChargeId(), 10000);
    $this->assertEquals($notificationUrl->getNotificationUrl(), 'http://your_domain/your_notification_url');
  }

  public function testExecuteUpdateNotificationUrl() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;

    $notificationUrl = $apiGN->updateNotificationUrl()
                             ->chargeId($chargeId)
                             ->notificationUrl('http://your_domain/your_notification_url');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('updateNotification', 200)]);

    $clientGZ = $notificationUrl->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $notificationUrl->guzzleClient($clientGZ);

    $resp = $notificationUrl->run()
                            ->response();

    $this->assertEquals($resp['code'], 200);
  }
}