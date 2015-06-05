<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiNotificationTest extends Base {

  public function testGetNotifications() {
    $apiGN = self::createApiGN();

    $notification = $apiGN->getNotifications()
                          ->notificationToken('notificationToken');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('notification', 200)]);

    $clientGZ = $notification->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $notification->guzzleClient($clientGZ);

    $resp = $notification->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['charge_id'], 10000);
    $this->assertEquals($resp['data']['total'], 34725);
    $this->assertEquals($resp['data']['status'], 'waiting');
    $this->assertEquals($resp['data']['custom_id'], 'MyID');
    $this->assertEquals($resp['data']['created_at'], '2015-03-26 08:46:00');
    $this->assertEquals(count($resp['data']['history']), 2);
    $this->assertEquals($resp['data']['history'][0]['status'], 'new');
    $this->assertEquals($resp['data']['history'][0]['timestamp'], '2015-03-26 08:46:00');
    $this->assertEquals($resp['data']['history'][1]['status'], 'waiting');
    $this->assertEquals($resp['data']['history'][1]['timestamp'], '2015-03-26 09:22:15');
  }
}