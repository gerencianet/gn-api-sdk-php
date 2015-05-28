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
 * Gerencianet's notification class
 *
 * Implements how to use Gerencianet's notification
 *
 * @package Gerencianet
 */
class ApiNotification extends ApiBase {

  /**
   * Transaction's notification token
   *
   * @var string
   */
  private $_notificationToken;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/notification');
  }

  /**
   * Set the notification token
   *
   * @param  string $notificationToken
   * @return ApiNotification
   */
  public function notificationToken($notificationToken) {
    $this->_notificationToken = $notificationToken;
    return $this;
  }

  /**
   * Get the notification token
   *
   * @return ApiNotification
   */
  public function getNotificationToken() {
    return $this->_notificationToken;
  }


  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiNotification
   */
  public function mapData() {
    $this->_data['notification'] = $this->_notificationToken;

    return $this;
  }
}