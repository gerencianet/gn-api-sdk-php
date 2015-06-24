<?php

use Gerencianet\Gerencianet;
use Gerencianet\Models\Address;
use Gerencianet\Models\Carnet;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Item;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\PostOfficeService;
use Gerencianet\Models\Repass;
use Gerencianet\Models\Shipping;
use Gerencianet\Webservices\ApiBase;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Message\Response;

class Base extends PHPUnit_Framework_TestCase {

  public function createApiGN() {
    $apiKey = 'Client_Id_Test';
    $apiSecret = 'Client_Secret_Test';
    return new Gerencianet($apiKey, $apiSecret);
  }

  public function repass() {
    $repass = new Repass();

    return $repass->payeeCode('payee_code_to_repass')
                  ->percentage(700);
  }

  public function item() {
    $item = new Item();

    return $item->name('Item')
                ->value(5000)
                ->amount(2)
                ->addRepass(self::repass());
  }

  public function itemWithoutRepass() {
    $item = new Item();

    return $item->name('Item')
                ->value(5000)
                ->amount(2);
  }

  public function shipping() {
    $shipping = new Shipping();

    return $shipping->payeeCode('payee_code_to_repass')
                    ->name('Shipping')
                    ->value(1575);
  }

  public function metadata() {
    $metadata = new Metadata();

    return $metadata->customId('MyID')
                    ->notificationUrl('http://your_domain/your_notification_url');
  }

  public function createPlan() {
    $apiGN = self::createApiGN();

    return $apiGN->createPlan()
                 ->name('Teste')
                 ->repeats(10)
                 ->interval(1);
  }

  public function deletePlan() {
    $apiGN = self::createApiGN();

    return $apiGN->deletePlan()
                 ->planId(13000);
  }

  public function createCharge() {
    $apiGN = self::createApiGN();

    return $apiGN->createCharge()
                 ->addItem(self::item())
                 ->addItems([self::item(), self::item()])
                 ->addShipping(self::shipping())
                 ->addShippings([self::shipping(), self::shipping()])
                 ->metadata(self::metadata());
  }

  public function createSubscription() {
    $planId = 13000;

    $apiGN = self::createApiGN();

    return $apiGN->createSubscription()
                 ->addItem(self::itemWithoutRepass())
                 ->metadata(self::metadata())
                 ->planId($planId);
  }

  public function address() {
    $address = new Address();

    return $address->street('Street 3')
                   ->number('10')
                   ->neighborhood('Bauxita')
                   ->zipcode('35400000')
                   ->city('Ouro Preto')
                   ->state('MG');
  }

  public function customer() {
    $customer = new Customer();

    return $customer->name('Gorbadoc Oldbuck')
                    ->email('oldbuck@gerencianet.com.br')
                    ->document('04267484171')
                    ->birth('1977-01-15')
                    ->phoneNumber('5144916523')
                    ->address(self::address());
  }

  public function postOfficeService() {
    $postOfficeService = new PostOfficeService();

    return $postOfficeService->sendTo('customer');
  }

  public function createCarnet() {
    $apiGN = self::createApiGN();

    return $apiGN->createCarnet()
                 ->addItem(self::itemWithoutRepass())
                 ->addItems([self::itemWithoutRepass(), self::itemWithoutRepass()])
                 ->metadata(self::metadata())
                 ->customer(self::customer())
                 ->expireAt('2019-12-31')
                 ->repeats(3)
                 ->splitItems(false)
                 ->postOfficeService(self::postOfficeService())
                 ->addInstruction('Instruction 1')
                 ->addInstructions(['Instruction 2', 'Instruction 3', 'Instruction 4'])
                 ->carnetRate(357);
  }

  public function getMockResponse($filename) {
    $mockResponse = new Response(200);
    $mockResponseBody = Stream::factory(file_get_contents(
        __DIR__.'/mock/'.$filename.'.json')
    );
    $mockResponse->setBody($mockResponseBody);

    return $mockResponse;
  }
}