<?php

namespace Gerencianet\Webservices;

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
 * Gerencianet's notification URL class
 *
 * Implements how to use Gerencianet's notification URL
 *
 * @package Gerencianet
 */
class ApiUpdateSubscriptionMetadata extends ApiBase {

  /**
   * URL that specify where subscription's notifications must be sent
   *
   * @var string
   */
  private $_notificationUrl;

  /**
   * Id that represents the subscription at the integrator's system
   *
   * @var string
   */
  private $_customId;

  /**
   * Subscription id that will be updated
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
    $this->setUrl('/subscription/metadata/update');
  }

  /**
   * Sets the value of notification URL
   *
   * @param string $notificationUrl
   * @return ApiUpdateSubscriptionMetadata
   */
  public function notificationUrl($notificationUrl) {
    $this->_notificationUrl = $notificationUrl;
    return $this;
  }

  /**
   * Sets the value of custom id
   *
   * @param string $customId
   * @return ApiUpdateSubscriptionMetadata
   */
  public function customId($customId) {
    $this->_customId = $customId;
    return $this;
  }

  /**
   * Gets the value of notification URL
   *
   * @return string
   */
  public function getNotificationUrl() {
    return $this->_notificationUrl;
  }

  /**
   * Gets the value of custom id
   *
   * @return string
   */
  public function getCustomId() {
    return $this->_customId;
  }

  /**
   * Set subscription id of subscription
   *
   * @param  integer $subscriptionId
   * @return ApiUpdateSubscriptionMetadata
   */
  public function subscriptionId($subscriptionId) {
    $this->_subscriptionId = (int)$subscriptionId;
    return $this;
  }

  /**
   * Get subscription id of subscription
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
   * @return ApiUpdateSubscriptionMetadata
   */
  public function mapData() {
    $this->_data['subscription_id'] = $this->_subscriptionId;

    if($this->_notificationUrl){
      $this->_data['notification_url'] = $this->_notificationUrl;
    }
    if($this->_customId){
      $this->_data['custom_id'] = $this->_customId;  
    }

    return $this;
  }
}