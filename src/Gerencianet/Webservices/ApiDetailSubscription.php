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
 * Gerencianet's detail subscription class
 *
 * Implements how to use Gerencianet's detail subscription
 *
 * @package Gerencianet
 */
class ApiDetailSubscription extends ApiBase {

  /**
   * Subscription id to detail
   *
   * @var integer
   */
  private $_subscriptionId;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/subscription/detail');
  }

  /**
   * Set subscription id
   *
   * @param  integer $id
   * @return ApiDetailSubscription
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
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiDetailSubscription
   */
  public function mapData() {
    $this->_data['subscription_id'] = $this->_subscriptionId;

    return $this;
  }
}
