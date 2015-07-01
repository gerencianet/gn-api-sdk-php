<?php

require_once __DIR__.'/Base.php';

class JuridicalPersonTest extends Base {

  public function testJuridicalPerson() {
    $juridicalPerson = self::juridicalPerson();

    $this->assertNotEmpty($juridicalPerson);
    $this->assertEquals($juridicalPerson->getCorporateName(), 'Fictional Company');
    $this->assertEquals($juridicalPerson->getCnpj(), '52841284000142');
  }
}