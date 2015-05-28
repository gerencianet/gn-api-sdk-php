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
 * Gerencianet's subscription class
 *
 * Class that abstract and return subscription attributes as required for api
 * @package Gerencianet
 */
class Subscription {

  /**
   * Repeats of subscription
   *
   * @var integer
   */
  private $_repeats;

  /**
   * Billing interval of subscription
   *
   * @var integer
   */
  private $_interval;

  /**
   * Set the repeats of subscription
   *
   * @param integer $repeats
   * @return Subscription
   */
  public function repeats($repeats) {
    $this->_repeats = $repeats;
    return $this;
  }

  /**
   * Gets the repeats of subscription
   *
   * @return integer
   */
  public function getRepeats() {
    return $this->_repeats;
  }

  /**
   * Sets the interval of subscription
   *
   * @param integer $interval
   * @return Subscription
   */
  public function interval($interval) {
    $this->_interval = $interval;
    return $this;
  }

  /**
   * Gets the interval of subscription
   *
   * @return integer
   */
  public function getInterval() {
    return $this->_interval;
  }

  /**
   * Get mapped subscription to be used in Gerencianet's api
   *
   * @return array
   */
  public function toArray() {
    $subscription = ['interval' => $this->_interval];

    if($this->_repeats) {
      $subscription['repeats'] = $this->_repeats;
    }

    return $subscription;
  }
}