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
 * Gerencianet's shipping class
 *
 * Class that abstract and return shipping attributes as required for api
 * @package Gerencianet
 */
class Shipping {

  /**
   * Payee code of account that will receive the shipping
   *
   * @var string
   */
  private $_payeeCode;

  /**
   * Name of shipping
   *
   * @var string
   */
  private $_name;

  /**
   * Value of shipping
   *
   * @var integer
   */
  private $_value;

  /**
   * Set payee code of shipping
   *
   * @param  string $payeeCode
   * @return Shipping
   */
  public function payeeCode($payeeCode) {
    $this->_payeeCode = $payeeCode;
    return $this;
  }

  /**
   * Get payee code of shipping
   *
   * @return string
   */
  public function getPayeeCode() {
    return $this->_payeeCode;
  }


  /**
   * Set name of shipping
   *
   * @param  string $name
   * @return Shipping
   */
  public function name($name) {
    $this->_name = $name;
    return $this;
  }

  /**
   * Get name of shipping
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set value of shipping
   *
   * @param  integer $value
   * @return Shipping
   */
  public function value($value) {
    $this->_value = (int)$value;
    return $this;
  }

  /**
   * Get value of shipping
   *
   * @return integer
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * Get the shipping as array
   *
   * @return array
   */
  public function toArray() {
    $shipping = [
      'name' => $this->_name,
      'value' => $this->_value
    ];

    if($this->_payeeCode) {
      $shipping['payee_code'] = $this->_payeeCode;
    }

    return $shipping;
  }
}