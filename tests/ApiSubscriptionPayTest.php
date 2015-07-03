<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPaySubscriptioneTest extends Base {

  public function testPaymentCreditCard() {
    $apiGN = self::createApiGN();

    $subscriptionId = 10000;
    $paymentToken = 'payment_token';

    $payment = $apiGN->paySubscription()
                     ->subscriptionId($subscriptionId)
                     ->method('credit_card')
                     ->paymentToken($paymentToken)
                     ->billingAddress(self::address());

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('subscriptionCreditCard', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['data']);
    $this->assertEquals($resp['data']['subscription_id'], 10000);
    $this->assertEquals($resp['data']['total'], 36999);
    $this->assertEquals($resp['data']['payment'], 'credit_card');
  }
}