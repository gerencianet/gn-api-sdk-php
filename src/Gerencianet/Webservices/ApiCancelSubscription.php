<?php

namespace Gerencianet\Webservices;

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
 * Gerencianet's cancel subscription class
 *
 * Implements how to use Gerencianet's cancel subscription
 *
 * @package Gerencianet
 */
class ApiCancelSubscription extends ApiBase {

  /**
   * Subscription id to cancel
   *
   * @var integer
   */
  private $_subscriptionId;

  /**
   * Who is canceling
   *
   * @var boolean
   */
  private $_isCustomer;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/subscription/cancel');
  }

  /**
   * Set subscription id
   *
   * @param  integer $id
   * @return ApiCancelSubscription
   */
  public function subscriptionId($id) {
    $this->_subscriptionId = (int)$id;
    return $this;
  }

  /**
   * Get subscription id
   *
   * @return integer
   */
  public function getSubscriptionId() {
    return $this->_subscriptionId;
  }

  /**
   * Set if who is canceling is customer
   *
   * @param  boolean $isCustomer
   * @return ApiCancelSubscription
   */
  public function isCustomer($isCustomer) {
    $this->_isCustomer = $isCustomer;
    return $this;
  }

  /**
   * Get if who is canceling is customer
   *
   * @return boolean
   */
  public function getIsCustomer() {
    return $this->_isCustomer;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiCancelSubscription
   */
  public function mapData() {
    $this->_data['subscription_id'] = $this->_subscriptionId;

    if(is_bool($this->_isCustomer)) {
      $this->_data['customer'] = $this->_isCustomer;
    }

    return $this;
  }
}
