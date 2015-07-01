<?php

require_once __DIR__.'/Base.php';

class CustomerTest extends Base {

  public function testCustomer() {
    $customer = self::customer();

    $this->assertNotEmpty($customer);
    $this->assertEquals($customer->getName(), 'Gorbadoc Oldbuck');
    $this->assertEquals($customer->getEmail(), 'oldbuck@gerencianet.com.br');
    $this->assertEquals($customer->getCpf(), '04267484171');
    $this->assertEquals($customer->getBirth(), '1977-01-15');
    $this->assertEquals($customer->getPhoneNumber(), '5144916523');
    $this->assertNotEmpty($customer->getAddress());
    $this->assertNotEmpty($customer->getJuridicalPerson());

    $addressCustomer = $customer->getAddress();
    $this->assertEquals($addressCustomer->getStreet(), 'Street 3');
    $this->assertEquals($addressCustomer->getNumber(), '10');
    $this->assertEquals($addressCustomer->getNeighborhood(), 'Bauxita');
    $this->assertEquals($addressCustomer->getZipcode(), '35400000');
    $this->assertEquals($addressCustomer->getCity(), 'Ouro Preto');
    $this->assertEquals($addressCustomer->getState(), 'MG');

    $juridicalPerson = $customer->getJuridicalPerson();
    $this->assertEquals($juridicalPerson->getCorporateName(), 'Fictional Company');
    $this->assertEquals($juridicalPerson->getCnpj(), '52841284000142');
  }
}