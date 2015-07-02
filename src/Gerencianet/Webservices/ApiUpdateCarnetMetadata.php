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
class ApiUpdateCarnetMetadata extends ApiBase {

  /**
   * URL that specify where carnet's notifications must be sent
   *
   * @var string
   */
  private $_notificationUrl;

  /**
   * Id that represents the carnet at the integrator's system
   *
   * @var string
   */
  private $_customId;

  /**
   * Carnet id that will be updated
   *
   * @var integer
  */
  private $_carnetId;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/carnet/metadata/update');
  }

  /**
   * Sets the value of notification URL
   *
   * @param string $notificationUrl
   * @return ApiUpdateCarnetMetadata
   */
  public function notificationUrl($notificationUrl) {
    $this->_notificationUrl = $notificationUrl;
    return $this;
  }

  /**
   * Sets the value of custom id
   *
   * @param string $customId
   * @return ApiUpdateCarnetMetadata
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
   * Set carnet id of carnet
   *
   * @param  integer $carnetId
   * @return ApiUpdateCarnetMetadata
   */
  public function carnetId($carnetId) {
    $this->_carnetId = (int)$carnetId;
    return $this;
  }

  /**
   * Get carnet id of carnet
   *
   * @return integer
   */
  public function getCarnetId() {
    return $this->_carnetId;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiUpdateCarnetMetadata
   */
  public function mapData() {
    $this->_data['carnet_id'] = $this->_carnetId;

    if($this->_notificationUrl){
      $this->_data['notification_url'] = $this->_notificationUrl;
    }
    if($this->_customId){
      $this->_data['custom_id'] = $this->_customId;  
    }

    return $this;
  }
}