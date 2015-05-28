<?php

require_once __DIR__.'/Base.php';

class AddressTest extends Base {
  public function testAddress() {
    $address = self::createAddress();

    $this->assertNotEmpty($address);
    $this->assertEquals($address->getStreet(), 'Street 3');
    $this->assertEquals($address->getNumber(), '10');
    $this->assertEquals($address->getNeighborhood(), 'Bauxita');
    $this->assertEquals($address->getZipcode(), '35400000');
    $this->assertEquals($address->getCity(), 'Ouro Preto');
    $this->assertEquals($address->getState(), 'MG');
  }
}