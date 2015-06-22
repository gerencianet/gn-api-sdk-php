<?php

require_once __DIR__.'/Base.php';

class ShippingTest extends Base {

  public function testShipping() {
    $shipping = self::shipping();

    $this->assertNotEmpty($shipping);
    $this->assertEquals($shipping->getPayeeCode(), 'payee_code_to_repass');
    $this->assertEquals($shipping->getName(), 'Shipping');
    $this->assertEquals($shipping->getValue(), 1575);
  }
}