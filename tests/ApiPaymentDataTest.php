<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPaymentDataTest extends Base {

  public function testPaymentDataBankingBillet() {
    $apiGN = self::createApiGN();

    $paymentData = $apiGN->getPaymentData()
                         ->type('banking_billet')
                         ->value(10000);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('paymentDataBankingBillet', 200)]);

    $clientGZ = $paymentData->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $paymentData->guzzleClient($clientGZ);

    $resp = $paymentData->run()
                        ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['total'], 10150);
    $this->assertEquals($resp['data']['rate'], 150);
    $this->assertEquals($resp['data']['currency'], '101,50');
  }

  public function testPaymentDataCreditCard() {
    $apiGN = self::createApiGN();

    $paymentData = $apiGN->getPaymentData()
                         ->type('mastercard')
                         ->value(10000);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('paymentDataCreditCard', 200)]);

    $clientGZ = $paymentData->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $paymentData->guzzleClient($clientGZ);

    $resp = $paymentData->run()
                        ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['rate'], 150);
    $this->assertEquals($resp['data']['name'], 'mastercard');
    $this->assertEquals(count($resp['data']['installments']), 12);
    $this->assertEquals($resp['data']['installments'][11]['installment'], 12);
    $this->assertEquals($resp['data']['installments'][11]['has_interest'], true);
    $this->assertEquals($resp['data']['installments'][11]['value'], 1072);
    $this->assertEquals($resp['data']['installments'][11]['currency'], '10,72');
    $this->assertEquals($resp['data']['installments'][11]['interest_percentage'], 199);
  }
}