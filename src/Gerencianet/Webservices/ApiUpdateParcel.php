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
 * Gerencianet's update parcel class
 *
 * Implements how to use Gerencianet's update parcel
 *
 * @package Gerencianet
 */
class ApiUpdateParcel extends ApiBase {

  /**
   * Charge id that will be updated
   *
   * @var integer
  */
  private $_chargeId;

  /**
   * New expiration date for 'carnet parcel'. The required format is 'YYYY-mm-dd'
   *
   * @var string
   */
  private $_expireAt;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/carnet/parcel/update');
  }

  /**
   * Set charge id of charge
   *
   * @param  integer $chargeId
   * @return ApiUpdateParcel
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
   * Set a new expiration date of banking billet. The required format is 'YYYY-mm-dd'
   *
   * @param  string $expireAt
   * @return ApiUpdateParcel
   */
  public function expireAt($expireAt) {
    $expireAt = str_replace('/', '-', $expireAt);
    $this->_expireAt = date("Y-m-d", strtotime($expireAt));
    return $this;
  }

  /**
   * Get a new expiration date of banking billet
   *
   * @return string
   */
  public function getExpireAt() {
    return $this->_expireAt;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiUpdateParcel
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    $this->_data['expire_at'] = $this->_expireAt;

    return $this;
  }
}