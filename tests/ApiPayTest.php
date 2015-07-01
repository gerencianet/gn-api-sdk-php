<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPayTest extends Base {

  public function testPaymentBankingBillet() {
    $apiGN = self::createApiGN();

    $chargeId = 11000;

    $payment = $apiGN->definePayment()
                     ->chargeId($chargeId)
                     ->method('banking_billet')
                     ->expireAt('2020-03-19')
                     ->postOfficeService(self::postOfficeService())
                     ->addInstruction('Instruction 1')
                     ->addInstructions(['Instruction 2', 'Instruction 3', 'Instruction 4']);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('bankingBillet', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['charge_id'], 11000);
    $this->assertEquals($resp['data']['total'], 34875);
    $this->assertEquals($resp['data']['payment'], 'banking_billet');
    $this->assertEquals($resp['data']['barcode'], '99999.99999 99999.999999 99999.999999 9 99999999999999');
    $this->assertEquals($resp['data']['link'], 'https://boleto.gerencianet.com.br/emissao/99999_9999_CORXI4/A4XB-99999-99999-BRABO1');
    $this->assertEquals($resp['data']['expire_at'], '2020-03-19');
  }

  public function testPaymentCreditCard() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;
    $paymentToken = 'payment_token';

    $payment = $apiGN->definePayment()
                     ->chargeId($chargeId)
                     ->method('credit_card')
                     ->installments(3)
                     ->paymentToken($paymentToken)
                     ->billingAddress(self::address());

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('creditCard', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['charge_id'], 10000);
    $this->assertEquals($resp['data']['total'], 36999);
    $this->assertEquals($resp['data']['payment'], 'credit_card');
    $this->assertEquals($resp['data']['installments'], 3);
    $this->assertEquals($resp['data']['installment_value'], 12333);
  }
}