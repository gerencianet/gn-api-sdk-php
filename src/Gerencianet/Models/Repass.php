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
 * Gerencianet's repass class
 *
 * Class that abstract and return repass attributes as required for api
 * @package Gerencianet
 */
class Repass {

  /**
   * Payee code of repass
   *
   * @var string
   */
  private $_payeeCode;

  /**
   * Percentage of repass
   *
   * @var integer
   */
  private $_percentage;

  /**
   * Set payee code of repass
   *
   * @param  string $payeeCode
   * @return Repass
   */
  public function payeeCode($payeeCode) {
    $this->_payeeCode = $payeeCode;
    return $this;
  }

  /**
   * Get payee code of repass
   *
   * @return string
   */
  public function getPayeeCode() {
    return $this->_payeeCode;
  }

  /**
   * Set the percentage of repass
   *
   * @param  integer $percentage
   * @return Repass
   */
  public function percentage($percentage) {
    $this->_percentage = (int)$percentage;
    return $this;
  }

  /**
   * Get the percentage of repass
   *
   * @return integer
   */
  public function getPercentage() {
    return $this->_percentage;
  }

  /**
   * Get the repass as array
   *
   * @return array
   */
  public function toArray() {
    $repass = [
      'payee_code' => $this->_payeeCode,
      'percentage' => $this->_percentage
    ];

    return $repass;
  }
}
