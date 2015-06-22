<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiCustomerTest extends Base {

  public function testCustomer() {
    $apiGN = self::createApiGN();
    $customerData = self::customer();

    $chargeId = 10000;

    $customerToCharge = $apiGN->createCustomer()
                              ->chargeId($chargeId)
                              ->customer($customerData);

    $this->assertNotEmpty($customerToCharge);
    $this->assertEquals($customerToCharge->getChargeId(), 10000);
    $this->assertEquals($customerToCharge->getCustomer()->getName(), 'Gorbadoc Oldbuck');
    $this->assertEquals($customerToCharge->getCustomer()->getEmail(), 'oldbuck@gerencianet.com.br');
    $this->assertEquals($customerToCharge->getCustomer()->getDocument(), '04267484171');
    $this->assertEquals($customerToCharge->getCustomer()->getBirth(), '1977-01-15');
    $this->assertEquals($customerToCharge->getCustomer()->getPhoneNumber(), '5044916523');
  }

  public function testExecuteCustomer() {
    $apiGN = self::createApiGN();
    $customerData = self::customer();

    $chargeId = 10000;

    $customerToCharge = $apiGN->createCustomer()
                              ->chargeId($chargeId)
                              ->customer($customerData);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('customer', 200)]);

    $clientGZ = $customerToCharge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $customerToCharge->guzzleClient($clientGZ);

    $resp = $customerToCharge->run()
                             ->response();

    $this->assertEquals($resp['code'], 200);
  }
}