<?php

namespace Gerencianet;
use Gerencianet\Models\GerencianetException;
use Gerencianet\Webservices\ApiBase;
use Gerencianet\Webservices\ApiAssociateChargeCustomer;
use Gerencianet\Webservices\ApiCancelSubscription;
use Gerencianet\Webservices\ApiCharge;
use Gerencianet\Webservices\ApiChargePay;
use Gerencianet\Webservices\ApiDeletePlan;
use Gerencianet\Webservices\ApiDetailCharge;
use Gerencianet\Webservices\ApiDetailNotification;
use Gerencianet\Webservices\ApiDetailSubscription;
use Gerencianet\Webservices\ApiPaymentData;
use Gerencianet\Webservices\ApiPlan;
use Gerencianet\Webservices\ApiSubscription;
use Gerencianet\Webservices\ApiUpdateBillet;
use Gerencianet\Webservices\ApiUpdateChargeMetadata;

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
 * Gerencianet's Api class
 *
 * Class to use Gerencianet's webservices
 * @package Gerencianet
 */
class Gerencianet {

  /**
   * User's client id
   *
   * @var boolean
   */
  private $_clientId;

  /**
   * User's secret key
   *
   * @var string
   */
  private $_clientSecret;

  /**
   * Enable/disable test api
   *
   * @var boolean
   */
  private $_isTest;

  /**
   * Construct method
   *
   * @param string $clientId User's client id
   * @param string $clientSecret User's secret key
   * @param boolean $_isTest Enable/disable test api
   */
  public function __construct($clientId, $clientSecret, $isTest = false) {
    $this->_clientId = $clientId;
    $this->_clientSecret = $clientSecret;
    $this->_isTest = $isTest;
  }

  /**
   * Generate a charge
   *
   * @return ApiCharge
   */
  public function createCharge() {
    $api = new ApiCharge($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Update charge's metadata
   *
   * @return ApiUpdateChargeMetadata
   */
  public function updateChargeMetadata() {
    $api = new ApiUpdateChargeMetadata($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Add a customer to charge
   *
   * @return ApiAssociateChargeCustomer
   */
  public function associateCustomer() {
    $api = new ApiAssociateChargeCustomer($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

    /**
   * Generate a subscription
   *
   * @return ApiSubscription
   */
  public function createSubscription() {
    $api = new ApiSubscription($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }


  /**
   * Generate a payment to charge using checkout
   *
   * @return ApiChargePay
   */
  public function createPayment() {
    $api = new ApiChargePay($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Get available installments for credit card brand or value total to banking billet
   *
   * @return ApiPaymentData
   */
  public function getPaymentData() {
    $api = new ApiPaymentData($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail a notification using its token
   *
   * @return ApiDetailNotification
   */
  public function detailNotification() {
    $api = new ApiDetailNotification($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Cancel the subscription
   *
   * @return ApiCancelSubscription
   */
  public function cancelSubscription() {
    $api = new ApiCancelSubscription($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail the subscription
   *
   * @return ApiDetailSubscription
   */
  public function detailSubscription() {
    $api = new ApiDetailSubscription($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail the charge
   *
   * @return ApiDetailCharge
   */
  public function detailCharge() {
    $api = new ApiDetailCharge($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Create the plan
   *
   * @return ApiPlan
   */
  public function createPlan() {
    $api = new ApiPlan($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Delete a plan
   *
   * @return ApiDeletePlan
   */
  public function deletePlan() {
    $api = new ApiDeletePlan($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Updated a billet
   *
   * @return ApiUpdateBillet
   */
  public function updateBillet() {
    $api = new ApiUpdateBillet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

   /**
   * Error response handler.
   * This function prints the message of an exception or an string
   *
   * @param $e Exception or message to be printed
   */
  public static function error($e = '') {
    http_response_code(500);
    if($e instanceof GerencianetException) {
      echo $e->toString();
    } else if($e instanceof Exception) {
      echo $e->getMessage();
    } else {
      echo $e;
    }
  }

  /**
   * This function converts the response in JSON.
   *
   * @return string
   */
  public static function json($response) {
    return json_encode($response);
  }

}
