<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Gerencianet\Gerencianet;
use Gerencianet\Models\Address;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Item;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\Repass;
use Gerencianet\Models\Shipping;
use Gerencianet\Models\GerencianetException;

echo 'SDK GN API';
echo '<pre>';

$apiKey = 'Client_Id_efa72f36a4645867e8a16e68879b201ce73734ad';
$apiSecret = 'Client_Secret_60ed6ddaa9dda2ff669af954e92ae1761d271298';

try {
  $apiGN = new Gerencianet($apiKey, $apiSecret, true);

  $repass = new Repass();
  $repass->payeeCode('payee_code_to_repass')
         ->percentage(700);

  $item1 = new Item();
  $item1->name('Item 1')
        ->value(500)
        ->amount(2)
        ->addRepass($repass);

  $item2 = new Item();
  $item2->name('Item 2')
        ->value(1000);

  $address = new Address();
  $address->street('Street 3')
          ->number('10')
          ->neighborhood('Bauxita')
          ->zipcode('35400000')
          ->city('Ouro Preto')
          ->state('MG');

  $customer = new Customer();
  $customer->name('Gorbadoc Oldbuck')
           ->email('oldbuck@gerencianet.com.br')
           ->document('04267484171')
           ->birth('1977-01-15')
           ->phoneNumber('5044916523')
           ->address($address);

  $metadata = new Metadata();
  $metadata->customId('MyID')
           ->notificationUrl('http://your_domain/your_notification_url');

  $metadata2 = new Metadata();
  $metadata2->customId('MyID2')
            ->notificationUrl('http://your_domain/your_notification_url');

  $shipping1 = new Shipping();
  $shipping1->payeeCode('payee_code_to_repass')
            ->name('Shipping')
            ->value(1575);

  $shipping2 = new Shipping();
  $shipping2->payeeCode('payee_code_to_repass')
            ->name('Shipping 2')
            ->value(2000);

  $shipping3 = new Shipping();
  $shipping3->name('Shipping 3')
            ->value(2500);


  echo '</br>Installments for Mastercard:</br>';
  $respPaymentDataCard = $apiGN->getPaymentData()
                               ->type('mastercard')
                               ->value(10000)
                               ->run()
                               ->response();
  print_r($respPaymentDataCard);


  echo '</br>Total banking billet:</br>';
  $respPaymentDataBillet = $apiGN->getPaymentData()
                                 ->type('banking_billet')
                                 ->value(10000)
                                 ->run()
                                 ->response();
  print_r($respPaymentDataBillet);


  echo '</br>Charge (banking billet):</br>';
  $respCharge = $apiGN->createCharge()
                      ->addItem($item1)
                      ->addItem($item2)
                      ->addShipping($shipping1)
                      ->addShipping($shipping2)
                      ->metadata($metadata)
                      ->run()
                      ->response();
  print_r($respCharge);
  $chargeId = $respCharge['data']['charge_id'];


  echo '</br>Associating customer to a charge:</br>';
  $respCustomer = $apiGN->createCustomer()
                        ->chargeId($chargeId)
                        ->customer($customer)
                        ->run()
                        ->response();
  print_r($respCustomer);


  echo '</br>Paying with banking billet:</br>';
  $respPayment = $apiGN->createPayment()
                       ->chargeId($chargeId)
                       ->method('banking_billet')
                       ->expireAt('2015-12-31')
                       ->run()
                       ->response();
  print_r($respPayment);


  echo '</br>Detailing a charge:</br>';
  $respDetailCharge = $apiGN->detailCharge()
                            ->chargeId($chargeId)
                            ->run()
                            ->response();
  print_r($respDetailCharge);


  echo '</br>Charge (credit card):</br>';
  $respCharge2 = $apiGN->createCharge()
                       ->addItems([$item1, $item2])
                       ->addShippings([$shipping1, $shipping2])
                       ->metadata($metadata2)
                       ->customer($customer)
                       ->run()
                       ->response();
  print_r($respCharge2);
  $chargeId2 = $respCharge2['data']['charge_id'];
  $paymentToken = 'payment_token';


  echo '</br>Paying with credit card:</br>';
  $respPayment2 = $apiGN->createPayment()
                        ->chargeId($chargeId2)
                        ->method('credit_card')
                        ->installments(3)
                        ->paymentToken($paymentToken)
                        ->billingAddress($address)
                        ->run()
                        ->response();
  print_r($respPayment2);


  echo '</br>Create a plan:</br>';
  $responsePlan = $apiGN->createPlan()
                        ->name('Plan 1')
                        ->repeats(2)
                        ->interval(1)
                        ->run()
                        ->response();
  print_r($responsePlan);
  $planId = $responsePlan['data']['plan_id'];


  echo '</br>Subscription:</br>';
  $respSubscription = $apiGN->createCharge()
                            ->addItem($item2)
                            ->addShipping($shipping3)
                            ->planId($planId)
                            ->customer($customer)
                            ->run()
                            ->response();
  print_r($respSubscription);
  $chargeId3 = $respSubscription['data']['charge_id'];
  $subscriptionId = $respSubscription['data']['subscription_id'];
  $paymentToken2 = 'payment_token';


  echo '</br>Paying subscription:</br>';
  $respPaymentSubscription = $apiGN->createPayment()
                                   ->chargeId($chargeId3)
                                   ->method('credit_card')
                                   ->paymentToken($paymentToken2)
                                   ->billingAddress($address)
                                   ->run()
                                   ->response();
  print_r($respPaymentSubscription);


  echo '</br>Update charge metadata:</br>';
  $respUpdateNotification = $apiGN->updateChargeMetadata()
                                  ->chargeId($chargeId2)
                                  ->notificationUrl('http://your_domain/your_new_notification_url')
                                  ->customId('new_id')
                                  ->run()
                                  ->response();
  print_r($respUpdateNotification);


  echo '</br>Notification:</br>';
  $notificationToken = 'notification_token';
  $respNotification = $apiGN->getNotifications()
                            ->notificationToken($notificationToken)
                            ->run()
                            ->response();
  print_r($respNotification);


  echo '</br>Detailing subscription:</br>';
  $respDetailSubscription = $apiGN->detailSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->run()
                                  ->response();
  print_r($respDetailSubscription);


  echo '</br>Canceling subscription:</br>';
  $respCancelSubscription = $apiGN->cancelSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->isCustomer(true)
                                  ->run()
                                  ->response();
  print_r($respCancelSubscription);


  echo '</br>Delete a plan:</br>';
  $responsePlan1 = $apiGN->createPlan()
                         ->name('Plan to delete')
                         ->repeats(3)
                         ->interval(10)
                         ->run()
                         ->response();
  $planId1 = $responsePlan1['data']['plan_id'];
  $responseDeletePlan = $apiGN->deletePlan()
                        ->planId($planId1)
                        ->run()
                        ->response();
  print_r($responseDeletePlan);

} catch(GerencianetException $e) {
  Gerencianet::error($e);
} catch(Exception $ex) {
  Gerencianet::error($ex);
}