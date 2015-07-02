<?php

namespace Gerencianet\Webservices;
use Gerencianet\Models\Address;

/**
 * Library to use Gerencianet's Api
 *
 * @author Cecilia Deveza <suportetecnico@gerencianet.com.br>
 * @author Danniel Hugo <suportetecnico@gerencianet.com.br>
 * @author Francisco Thiene <suportetecnico@gerencianet.com.br>
 * @author Talita Campos <suportetecnico@gerencianet.com.br>
 * @author Thomaz Feitoza <suportetecnico@gerencianet.com.br>
 *
 * @license http://opensource.org/licenses/MIT
 */

/**
 * Gerencianet's subscription pay class
 *
 * Implements how to use Gerencianet's subscription pay
 *
 * @package Gerencianet
 */
class ApiPaySubscription extends ApiBase {

  /**
   * Billing address
   *
   * @var Address
   */
  private $_billingAddress;

  /**
   * Payment method. Can be only 'credit_card'
   *
   * @var string
   */
  private $_method = 'credit_card';

  /**
   * Expiration date for 'banking_billet'. The required format is 'YYYY-mm-dd'
   *
   * @var string
   */
  private $_expireAt;

  /**
   * Subscription id that will be paid
   *
   * @var integer
  */
  private $_subscriptionId;

  /**
   * Payment token used for credit card
   *
   * @var string
   */
  protected $_paymentToken;

  /**
   * Post office service for banking billet
   *
   * @var PostOfficeService
   */
  private $_postOfficeService;

  /**
   * Set of instructions for banking billet
   *
   * @var array
   */
  private $_instructions;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/subscription/pay');
    $this->_instructions = [];
  }

  /**
   * Set a billing address of payment
   *
   * @param  Address $address
   * @return ApiPaySubscription
   */
  public function billingAddress(Address $address) {
    $this->_billingAddress = $address;
    return $this;
  }

  /**
   * Get billing address of payment
   *
   * @return Address
   */
  public function getBillingAddress() {
    return $this->billingAddress;
  }

  /**
   * Set the method used to pay this charge. It can be 'credit_card' or 'banking_billet'
   *
   * @param  string $method
   * @return ApiPaySubscription
   */
  public function method($method) {
    $this->_method = $method;
    return $this;
  }

  /**
   * Get the method used to pay this charge
   *
   * @return string
   */
  public function getMethod() {
    return $this->_method;
  }

  /**
   * Set an expiration date of banking billet. The required format is 'YYYY-mm-dd'
   *
   * @param  string $expireAt
   * @return ApiPaySubscription
   */
  public function expireAt($expireAt) {
    $expireAt = str_replace('/', '-', $expireAt);
    $this->_expireAt = date("Y-m-d", strtotime($expireAt));
    return $this;
  }

  /**
   * Get an expiration date of banking billet
   *
   * @return string
   */
  public function getExpireAt() {
    return $this->_expireAt;
  }

  /**
   * Set charge id
   *
   * @param  integer $chargeId
   * @return ApiPaySubscription
   */
  public function chargeId($chargeId) {
    $this->_subscriptionId = (int)$chargeId;
    return $this;
  }

  /**
   * Get charge id
   *
   * @return integer
   */
  public function getChargeId() {
    return $this->_subscriptionId;
  }

  /**
   * Set payment token. Must be used just for 'credit_card'
   *
   * @param  string $paymentToken
   * @return ApiPaySubscription
   */
  public function paymentToken($paymentToken) {
    $this->_paymentToken = $paymentToken;
    return $this;
  }

  /**
   * Get payment token
   *
   * @return string
   */
  public function getPaymentToken() {
    return $this->_paymentToken;
  }

  /**
   * Set post office service
   *
   * @param  PostOfficeService $postOfficeService
   * @return ApiPaySubscription
   */
  public function postOfficeService($postOfficeService) {
    $this->_postOfficeService = $postOfficeService;
    return $this;
  }

  /**
   * Get post office service
   *
   * @return PostOfficeService
   */
  public function getPostOfficeService() {
    return $this->_postOfficeService;
  }

  /**
   * Add a new instruction to the set of instructions
   *
   * @param  string $instruction
   * @return ApiPaySubscription
   */
  public function addInstruction($instruction) {
    $this->_instructions[] = $instruction;
    return $this;
  }

  /**
   * Add a array of new instructions to the set of instructions
   *
   * @param  string $instructions
   * @return ApiPaySubscription
   */
  public function addInstructions(Array $instructions) {
    $this->_instructions = array_merge($this->_instructions, $instructions);
    return $this;
  }

  /**
   * Get instructions of banking billet
   *
   * @return array
   */
  public function getInstructions() {
    return $this->_instructions;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiPaySubscription
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_subscriptionId;

    $this->_data['payment'] = [];

    if($this->_method == 'credit_card') {
      $this->_data['payment']['credit_card'] = [];

      $this->_data['payment']['credit_card']['installments'] = 1;

      if($this->_paymentToken) {
        $this->_data['payment']['credit_card']['payment_token'] = $this->_paymentToken;
      }

      if($this->_billingAddress) {
        $this->_data['payment']['credit_card']['billing_address'] = $this->_billingAddress->toArray();
      }

    } else {
      $this->_data['payment']['banking_billet'] = [];

      if($this->_expireAt) {
        $this->_data['payment']['banking_billet']['expire_at'] = $this->_expireAt;
      } else {
        $this->_data['payment']['banking_billet']['expire_at'] = null;
      }

      if($this->_postOfficeService) {
        $postOfficeService = $this->_postOfficeService->toArray();

        if(!empty($postOfficeService)) {
          $this->_data['payment']['banking_billet']['post_office_service'] = $postOfficeService;
        }
      }

      if($this->_instructions) {
        $this->_data['payment']['banking_billet']['instructions'] = $this->_instructions;
      }
    }

    return $this;
  }
}
