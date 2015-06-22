<?php

require_once __DIR__.'/Base.php';

class MetadataTest extends Base {

  public function testNotification() {
    $metadata = self::createMetadata();

    $this->assertNotEmpty($metadata);
    $this->assertEquals($metadata->getCustomId(), 'MyID');
    $this->assertEquals($metadata->getNotificationUrl(), 'http://your_domain/your_notification_url');
  }
}