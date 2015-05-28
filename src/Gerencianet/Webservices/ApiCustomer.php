<?php

namespace Gerencianet\Webservices;
use Gerencianet\Models\Customer;

/**
 * Library to use Gerencianet's Api
 *
 * @author Danniel Hugo <suportetecnico@gerencianet.com.br>
 * @author Talita Campos <suportetecnico@gerencianet.com.br>
 * @author Francisco Thiene <suportetecnico@gerencianet.com.br>
 * @author Cecilia Deveza <suportetecnico@gerencianet.com.br>
 * @author Thomaz Feitoza <suportetecnico@gerencianet.com.br>
 *
 * @version 0.1.0
 * @license http://opensource.org/licenses/MIT
 */

/**
 * Gerencianet's customer class
 *
 * Implements how to add customer to Gerencianet's charge
 *
 * @package Gerencianet
 */
class ApiCustomer extends ApiBase {

  /**
   * Charge id that will be associated to the customer
   *
   * @var integer
   */
  private $_chargeId;

  /**
   * Customer's attributes
   *
   * @var Customer
   */
  private $_customer;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/customer');
  }

  /**
   * Set charge id of charge
   *
   * @param  integer $chargeId
   * @return ApiPayment
   */
  public function chargeId($chargeId) {
    $this->_chargeId = (int)$chargeId;
    return $this;
  }

  /**
   * Get charge id of charge
   *
   * @return integer
   */
  public function getChargeId() {
    return $this->_chargeId;
  }

  /**
   * Set a customer of charge
   *
   * @param  Customer $customer
   * @return ApiCustomer
   */
  public function customer(Customer $customer) {
    $this->_customer = $customer;
    return $this;
  }

  /**
   * Get a customer of charge
   *
   * @return Customer
   */
  public function getCustomer() {
    return $this->_customer;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiCustomer
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    if($this->_customer) {
      $this->_data['name'] = $this->_customer->getName();
      $this->_data['email'] = $this->_customer->getEmail();
      $this->_data['document'] = $this->_customer->getDocument();
      $this->_data['birth'] = $this->_customer->getBirth();
      $this->_data['phone_number'] = $this->_customer->getPhoneNumber();
    }

    return $this;
  }
}
