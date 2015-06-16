<?php

namespace Gerencianet\Models;

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
 * Gerencianet's post office service class
 *
 * Class that abstract and return post office service attributes as required for api
 * @package Gerencianet
 */
class PostOfficeService {

  /**
   * Who will receive the banking billet or carnet billet by post office service.
   * The available values are 'customer' or 'seller'.
   *
   * @var string
   */
  private $_sendTo = 'customer';

  /**
   * Set the value of send to
   *
   * @param string $sendTo
   * @return PostOfficeService
   */
  public function sendTo($sendTo) {
    if($sendTo === 'customer' || $sendTo === 'seller')
      $this->_sendTo = $sendTo;
    return $this;
  }

  /**
   * Get the value of send to
   *
   * @return string
   */
  public function getSendTo() {
    return $this->_sendTo;
  }

  /**
   * Get mapped Gerencianet post office service as required for api
   *
   * @return array
   */
  public function toArray() {
    $arr = [];

    if($this->_sendTo) {
      $arr['send_to'] = $this->_sendTo;
    }

    return $arr;
  }
}