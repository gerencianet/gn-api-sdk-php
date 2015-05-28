<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPaymentTest extends Base {

  public function testPaymentBankingBillet() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;

    $payment = $apiGN->createPayment()
                     ->chargeId($chargeId)
                     ->method('banking_billet')
                     ->expireAt('2020-03-19');

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('bankingBillet', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['response']);
    $this->assertEquals($resp['response']['transaction'], 11200);
    $this->assertEquals($resp['response']['total'], 34875);
    $this->assertEquals($resp['response']['payment'], 'banking_billet');
    $this->assertEquals($resp['response']['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
    $this->assertEquals($resp['response']['link'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CORXI4/A4XB-99999-99999-BRABO1');
    $this->assertEquals($resp['response']['expire_at'], '2020-03-19');
  }

  public function testPaymentCreditCard() {
    $apiGN = self::createApiGN();
    $address = self::createAddress();

    $chargeId = 10000;
    $paymentToken = 'payment_token';

    $payment = $apiGN->createPayment()
                     ->chargeId($chargeId)
                     ->method('credit_card')
                     ->installments(3)
                     ->paymentToken($paymentToken)
                     ->billingAddress($address);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('creditCard', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['response']);
    $this->assertEquals($resp['response']['transaction'], 11000);
    $this->assertEquals($resp['response']['total'], 36999);
    $this->assertEquals($resp['response']['payment'], 'credit_card');
    $this->assertEquals($resp['response']['installments'], 3);
    $this->assertEquals($resp['response']['installment_value'], 12333);
  }
}