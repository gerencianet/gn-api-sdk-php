<?php

require_once __DIR__.'/Base.php';

class ItemTest extends Base {

  public function testItem() {
    $item = self::item();

    $this->assertNotEmpty($item);
    $this->assertEquals($item->getName(), 'Item');
    $this->assertEquals($item->getValue(), 5000);
    $this->assertEquals($item->getAmount(), 2);
    $this->assertNotEmpty($item->getRepasses());
    $this->assertEquals(count($item->getRepasses()), 1);
  }
}