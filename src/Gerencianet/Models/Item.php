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
 * Gerencianet's item class
 *
 * Class that abstract and return item attributes as required for api
 * @package Gerencianet
 */
class Item {

  /**
   * Name of item
   *
   * @var string
   */
  private $_name;

  /**
   * Value of item
   *
   * @var integer
   */
  private $_value;

  /**
   * Amount of item
   *
   * @var integer
   */
  private $_amount = 1;

  /**
   * Set of marketplace repasses of item
   *
   * @var array
   */
  private $_repasses;

  /**
   * Set name of item
   *
   * @param  string $name
   * @return Item
   */
  public function name($name) {
    $this->_name = $name;
    return $this;
  }

  /**
   * Get name of item
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set value of item
   *
   * @param  integer $value
   * @return Item
   */
  public function value($value) {
    $this->_value = (int)$value;
    return $this;
  }

  /**
   * Get value of item
   *
   * @return integer
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * Set amount of item
   *
   * @param  integer $amount
   * @return Item
   */
  public function amount($amount) {
    $this->_amount = (int)$amount;
    return $this;
  }

  /**
   * Get amount of item
   *
   * @return integer
   */
  public function getAmount() {
    return $this->_amount;
  }

  /**
   * Add a new repass to the set of repasses
   *
   * @param  Repass $repass
   * @return Item
   */
  public function addRepass(Repass $repass) {
    $this->_repasses[] = $repass->toArray();
    return $this;
  }

  /**
   * Add a array of new repasses to the set of repasses
   *
   * @param  Array $repasses
   * @return Item
   */
  public function addRepasses($repasses) {
    foreach($repasses as $repass) {
      $this->_repasses[] = $repass->toArray();
    }
    return $this;
  }

  /**
   * Get the set of repasses
   *
   * @return array
   */
  public function getRepasses() {
    return $this->_repasses;
  }
  /**
   * Get the item as array
   *
   * @return array
   */
  public function toArray() {
    $item = [
      'name' => $this->_name,
      'value' => $this->_value,
      'amount' => $this->_amount
    ];

    if($this->_repasses) {
      $item['marketplace'] = [
        'repasses' => $this->_repasses
      ];
    }

    return $item;
  }
}