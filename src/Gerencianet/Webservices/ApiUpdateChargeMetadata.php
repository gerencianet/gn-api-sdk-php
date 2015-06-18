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
 * @license http://opensource.org/licenses/MIT
 */

/**
 * Gerencianet's notification URL class
 *
 * Implements how to use Gerencianet's notification URL
 *
 * @package Gerencianet
 */
class ApiUpdateChargeMetadata extends ApiBase {

  /**
   * URL that specify where charge's notifications must be sent
   *
   * @var string
   */
  private $_notificationUrl;

  /**
   * Id that represents the charge at the integrator's system
   *
   * @var string
   */
  private $_customId;

  /**
   * Charge id that will be updated
   *
   * @var integer
  */
  private $_chargeId;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/charge/metadata/update');
  }

  /**
   * Sets the value of notification URL
   *
   * @param string $notificationUrl
   * @return ApiUpdateChargeMetadata
   */
  public function notificationUrl($notificationUrl) {
    $this->_notificationUrl = $notificationUrl;
    return $this;
  }

  /**
   * Sets the value of custom id
   *
   * @param string $customId
   * @return ApiUpdateChargeMetadata
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
   * Set charge id of charge
   *
   * @param  integer $chargeId
   * @return ApiUpdateChargeMetadata
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
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiUpdateChargeMetadata
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    $this->_data['notification_url'] = $this->_notificationUrl;

    $this->_data['custom_id'] = $this->_customId;

    return $this;
  }
}