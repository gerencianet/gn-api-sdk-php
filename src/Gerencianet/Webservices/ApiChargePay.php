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
 * Gerencianet's payment class
 *
 * Implements how to use Gerencianet's payment
 *
 * @package Gerencianet
 */
class ApiChargePay extends ApiBase {

  /**
   * Billing address
   *
   * @var Address
   */
  private $_billingAddress;

  /**
   * Payment method. Can be 'credit_card' or 'banking_billet'
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
   * Installments of payment. It defines how many times the value of charge will be
   * divided when using credit card
   *
   * @var string
   */
  private $_installments;

  /**
   * Charge id that will be paid
   *
   * @var integer
  */
  private $_chargeId;

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
    $this->setUrl('/charge/pay');
    $this->_instructions = [];
  }

  /**
   * Set a billing address of payment
   *
   * @param  Address $address
   * @return ApiChargePay
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
   * @return ApiChargePay
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
   * @return ApiChargePay
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
   * Set the amount of installments of payment
   *
   * @param  integer $installments
   * @return ApiChargePay
   */
  public function installments($installments) {
    $this->_installments = (int)$installments;
    return $this;
  }

  /**
   * Get the amount of installments of payment
   *
   * @return integer
   */
  public function getInstallments() {
    return $this->_installments;
  }

  /**
   * Set charge id
   *
   * @param  integer $chargeId
   * @return ApiChargePay
   */
  public function chargeId($chargeId) {
    $this->_chargeId = (int)$chargeId;
    return $this;
  }

  /**
   * Get charge id
   *
   * @return integer
   */
  public function getChargeId() {
    return $this->_chargeId;
  }

  /**
   * Set payment token. Must be used just for 'credit_card'
   *
   * @param  string $paymentToken
   * @return ApiChargePay
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
   * @return ApiChargePay
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
   * @return ApiPayment
   */
  public function addInstruction($instruction) {
    $this->_instructions[] = $instruction;
    return $this;
  }

  /**
   * Add a array of new instructions to the set of instructions
   *
   * @param  string $instructions
   * @return ApiPayment
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
   * @return ApiChargePay
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    $this->_data['payment'] = [];

    if($this->_method == 'credit_card') {
      $this->_data['payment']['credit_card'] = [];

      if($this->_installments) {
        $this->_data['payment']['credit_card']['installments'] = $this->_installments;
      }

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
