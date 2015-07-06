<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Gerencianet\Gerencianet;
use Gerencianet\Models\Address;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Item;
use Gerencianet\Models\JuridicalPerson;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\PostOfficeService;
use Gerencianet\Models\Repass;
use Gerencianet\Models\Shipping;
use Gerencianet\Models\GerencianetException;

echo '<h1>SDK GERENCIANET - PHP</h1>';

$apiKey = 'your_client_id';
$apiSecret = 'your_client_secret';

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

  $juridicalPerson = new JuridicalPerson();
  $juridicalPerson->corporateName('Fictional Company')
                  ->cnpj('52.841.284/0001-42');

  $customer = new Customer();
  $customer->name('Gorbadoc Oldbuck')
           ->email('oldbuck@gerencianet.com.br')
           ->cpf('04267484171')
           ->birth('1977-01-15')
           ->phoneNumber('5144916523')
           ->address($address)
           ->juridicalPerson($juridicalPerson);

  $metadata = new Metadata();
  $metadata->customId('MyID')
           ->notificationUrl('http://your.domain/your_notification_url');

  $metadata2 = new Metadata();
  $metadata2->customId('MyID2')
            ->notificationUrl('http://your.domain/your_notification_url');

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

  $postOfficeService = new PostOfficeService();
  $postOfficeService->sendTo('customer');

  /*---------------------------------------------------------------------------------------------------*/

  echo '<h2>Charges</h2>';

  echo '<h3>Creating charges:</h3>';

  echo '<strong>Charge 1:</strong>';
  $respCharge1 = $apiGN->createCharge()
                      ->addItem($item1)
                      ->addItem($item2)
                      ->addShipping($shipping1)
                      ->addShipping($shipping2)
                      ->metadata($metadata)
                      ->run()
                      ->response();
  $chargeIdBillet = $respCharge1['data']['charge_id'];
  echo '<pre>';
  print_r($respCharge1);
  echo '</pre>';

  echo '<strong>Charge 2:</strong>';
  $respCharge2 = $apiGN->createCharge()
                       ->addItems([$item1, $item2])
                       ->addShippings([$shipping1, $shipping2])
                       ->metadata($metadata2)
                       ->customer($customer)
                       ->run()
                       ->response();
  $chargeIdCard   = $respCharge2['data']['charge_id'];
  echo '<pre>';
  print_r($respCharge2);
  echo '</pre>';

  /*--------------------------*/

  echo '<h3>Associating customer to a charge:</h3>';
  $respCustomer = $apiGN->associateChargeCustomer()
                        ->chargeId($chargeIdBillet)
                        ->customer($customer)
                        ->run()
                        ->response();
  echo '<pre>';
  print_r($respCustomer);
  echo '</pre>';

  /*--------------------------*/

  echo '<h3>Paying "Charge 1" with Banking Billet:</h3>';
  $respPayment1 = $apiGN->payCharge()
                       ->chargeId($chargeIdBillet)
                       ->method('banking_billet')
                       ->expireAt('2015-12-31')
                       ->postOfficeService($postOfficeService)
                       ->addInstruction('Instruction 1')
                       ->addInstructions(['Instruction 2', 'Instruction 3', 'Instruction 4'])
                       ->run()
                       ->response();
  echo '<pre>';
  print_r($respPayment1);
  echo '</pre>';

  echo '<h3>Paying "Charge 2" with Credit Card:</h3>';
  $paymentToken   = 'payment_token';
  $respPayment2 = $apiGN->payCharge()
                        ->chargeId($chargeIdCard)
                        ->method('credit_card')
                        ->installments(3)
                        ->paymentToken($paymentToken)
                        ->billingAddress($address)
                        ->run()
                        ->response();
  echo '<pre>';
  print_r($respPayment2);
  echo '</pre>';

  /*--------------------------*/

  echo '<h3>Detailing a charge:</h3>';
  $respDetailCharge = $apiGN->detailCharge()
                            ->chargeId($chargeIdBillet)
                            ->run()
                            ->response();
  echo '<pre>';
  print_r($respDetailCharge);
  echo '</pre>';

  echo '<h3>Updating charge metadata:</h3>';
  $respUpdateMetadata = $apiGN->updateChargeMetadata()
                              ->chargeId($chargeIdBillet)
                              ->notificationUrl('http://your.domain/your_new_notification_url')
                              ->customId('new_id')
                              ->run()
                              ->response();
  echo '<pre>';
  print_r($respUpdateMetadata);
  echo '</pre>';


  echo '<h3>Updating billet expiration date:</h3>';
  $respUpdateBillet = $apiGN->updateBillet()
                            ->chargeId($chargeIdBillet)
                            ->expireAt('2016-12-31')
                            ->run()
                            ->response();
  echo '<pre>';
  print_r($respUpdateBillet);
  echo '</pre>';

  /*---------------------------------------------------------------------------------------------------*/

  echo '<h2>Carnets</h2>';

  echo '<h3>Creating a carnet:</h3>';
  $respCarnet = $apiGN->createCarnet()
                      ->addItem($item2)
                      ->metadata($metadata)
                      ->customer($customer)
                      ->expireAt('2019-05-12')
                      ->repeats(2)
                      ->splitItems(true)
                      ->postOfficeService($postOfficeService)
                      ->addInstructions(['Instruction 1', 'Instruction 2', 'Instruction 3'])
                      ->run()
                      ->response();
  $carnetId = $respCarnet['data']['carnet_id'];
  echo '<pre>';
  print_r($respCarnet);
  echo '</pre>';

  echo '<h3>Detailing the carnet:</h3>';
  $respDetailCarnet = $apiGN->detailCarnet()
                            ->carnetId($carnetId)
                            ->run()
                            ->response();
  echo '<pre>';
  print_r($respDetailCarnet);
  echo '</pre>';

  echo '<h3>Updating a carnet parcel:</h3>';
  $respUpdateParcel = $apiGN->updateParcel()
                            ->carnetId($carnetId)
                            ->parcel(2)
                            ->expireAt('2020-10-24')
                            ->run()
                            ->response();
  echo '<pre>';
  print_r($respUpdateParcel);
  echo '</pre>';

  /*---------------------------------------------------------------------------------------------------*/

  echo '<h2>Subscriptions</h2>';

   echo '<h3>Creating a plan:</h3>';
  $responsePlan = $apiGN->createPlan()
                        ->name('Plan 1')
                        ->repeats(2)
                        ->interval(1)
                        ->run()
                        ->response();
  $planId = $responsePlan['data']['plan_id'];
  echo '<pre>';
  print_r($responsePlan);
  echo '</pre>';

  echo '<h3>Deleting a plan:</h3>';
  $responsePlan1 = $apiGN->createPlan()
                         ->name('Plan to delete')
                         ->repeats(3)
                         ->interval(10)
                         ->run()
                         ->response();
  $planId1 = $responsePlan1['data']['plan_id'];
  echo '<pre>';
  print_r($responsePlan1);
  echo '</pre>';

  $responseDeletePlan = $apiGN->deletePlan()
                        ->planId($planId1)
                        ->run()
                        ->response();
  echo '<pre>';
  print_r($responseDeletePlan);
  echo '</pre>';

  echo '<h3>Creating a subscription:</h3>';
  $respSubscription = $apiGN->createSubscription()
                            ->addItem($item2)
                            ->addShipping($shipping3)
                            ->planId($planId)
                            ->customer($customer)
                            ->run()
                            ->response();
  echo '<pre>';
  print_r($respSubscription);
  echo '</pre>';
  $chargeIdSubscription = $respSubscription['data']['charge_id'];
  $subscriptionId = $respSubscription['data']['subscription_id'];
  $paymentToken2 = 'payment_token';


  echo '<h3>Paying the subscription:</h3>';
  $respPaymentSubscription = $apiGN->payCharge()
                                   ->chargeId($chargeIdSubscription)
                                   ->method('credit_card')
                                   ->paymentToken($paymentToken2)
                                   ->billingAddress($address)
                                   ->run()
                                   ->response();
  echo '<pre>';
  print_r($respPaymentSubscription);
  echo '</pre>';


  echo '<h3>Detailing subscription:</h3>';
  $respDetailSubscription = $apiGN->detailSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->run()
                                  ->response();
  echo '<pre>';
  print_r($respDetailSubscription);
  echo '</pre>';


  echo '<h3>Canceling subscription:</h3>';
  $respCancelSubscription = $apiGN->cancelSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->isCustomer(true)
                                  ->run()
                                  ->response();
  echo '<pre>';
  print_r($respCancelSubscription);
  echo '</pre>';

  /*---------------------------------------------------------------------------------------------------*/

  echo '<h2>Notifications</h2>';

  echo '<h3>Getting a notification:</h3>';
  $notificationToken = 'notification_token';
  $respNotification = $apiGN->detailNotification()
                            ->notificationToken($notificationToken)
                            ->run()
                            ->response();
  echo '<pre>';
  print_r($respNotification);
  echo '</pre>';

  /*---------------------------------------------------------------------------------------------------*/

  echo '<h2>Payments</h2>';

  echo '<h3>Getting payment data - Using brand Mastercard:</h3>';
  $respPaymentDataCard = $apiGN->getPaymentData()
                               ->type('mastercard')
                               ->value(10000)
                               ->run()
                               ->response();
  echo '<pre>';
  print_r($respPaymentDataCard);
  echo '</pre>';

  /*---------------------------------------------------------------------------------------------------*/

} catch(GerencianetException $e) {
  Gerencianet::error($e);
} catch(Exception $ex) {
  Gerencianet::error($ex);
}