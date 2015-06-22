<?php

require_once __DIR__.'/Base.php';

class PostOfficeServiceTest extends Base {

  public function testPostOfficeService() {
    $postOfficeService = self::postOfficeService();

    $this->assertNotEmpty($postOfficeService);
    $this->assertEquals($postOfficeService->getSendTo(), 'customer');
  }
}