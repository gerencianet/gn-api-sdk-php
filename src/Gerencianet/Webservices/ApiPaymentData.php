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
 * Gerencianet's payment data class
 *
 * Implements how to use Gerencianet's payment data
 *
 * @package Gerencianet
 */
class ApiPaymentData extends ApiBase {

  /**
   * Payment type. Can be 'visa', 'mastercard', 'aura', 'jcb', 'elo', 'amex',
   * 'diners', 'discover' or 'banking_billet'
   *
   * @var string
   */
  private $_type = 'visa';

   /**
   * Charge value
   *
   * @var integer
  */
  private $_value;

  /**
   * Construct Method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/payment/data');
  }

  /**
   * Set a type of search
   *
   * @param  string $type
   * @return ApiPaymentData
   */
  public function type($type) {
    $this->_type = $type;
    return $this;
  }

  /**
   * Get a type of search
   *
   * @return string
   */
  public function getType() {
    return $this->_type;
  }

  /**
   * Set the value of search
   *
   * @param  integer $value
   * @return ApiPaymentData
   */
  public function value($value) {
    $this->_value = (int)$value;
    return $this;
  }

  /**
   * Get the value of search
   *
   * @return integer
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiPaymentData
   */
  public function mapData() {
    $this->_data['type'] = $this->_type;

    $this->_data['total'] = $this->_value;

    return $this;
  }
}
