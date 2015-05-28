<?php

namespace Gerencianet\Models;

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
 * Gerencianet's return class
 *
 * Class that abstract and return Gerencianet 'metadata' array as required for api
 * @package Gerencianet
 */
class Metadata {

  /**
   * Custom identifier of a transaction
   *
   * @var string
   */
  private $_customId;

  /**
   * Url that specify where transaction's notifications must be sent
   *
   * @var string
   */
  private $_notificationUrl;

  /**
   * Set the value of custom id
   *
   * @param string $id
   * @return Metadata
   */
  public function customId($id) {
    $this->_customId = $id;
    return $this;
  }

  /**
   * Get the value of custom id
   *
   * @return string
   */
  public function getCustomId() {
    return $this->_customId;
  }

  /**
   * Set the value of notification url
   *
   * @param string $notificationUrl
   * @return Metadata
   */
  public function notificationUrl($notificationUrl) {
    $this->_notificationUrl = $notificationUrl;
    return $this;
  }

  /**
   * Get the value of notification url
   *
   * @return string
   */
  public function getNotificationUrl() {
    return $this->_notificationUrl;
  }

  /**
   * Get mapped Gerencianet 'metadata' as required for api
   *
   * @return array
   */
  public function toArray() {
  	$arr = [];

  	if($this->_notificationUrl) {
  		$arr['notification_url'] = $this->_notificationUrl;
  	}

  	if($this->_customId) {
  		$arr['custom_id'] = $this->_customId;
  	}

  	return $arr;
  }
}