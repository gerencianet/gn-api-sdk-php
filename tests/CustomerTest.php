<?php

require_once __DIR__.'/Base.php';

class CustomerTest extends Base {

  public function testCustomer() {
    $customer = self::createCustomer();

    $this->assertNotEmpty($customer);
    $this->assertEquals($customer->getName(), 'Gorbadoc Oldbuck');
    $this->assertEquals($customer->getEmail(), 'oldbuck@gerencianet.com.br');
    $this->assertEquals($customer->getDocument(), '04267484171');
    $this->assertEquals($customer->getBirth(), '1977-01-15');
    $this->assertEquals($customer->getPhoneNumber(), '5044916523');
    $this->assertNotEmpty($customer->getAddress());

    $addressCustomer = $customer->getAddress();
    $this->assertEquals($addressCustomer->getStreet(), 'Street 3');
    $this->assertEquals($addressCustomer->getNumber(), '10');
    $this->assertEquals($addressCustomer->getNeighborhood(), 'Bauxita');
    $this->assertEquals($addressCustomer->getZipcode(), '35400000');
    $this->assertEquals($addressCustomer->getCity(), 'Ouro Preto');
    $this->assertEquals($addressCustomer->getState(), 'MG');
  }
}