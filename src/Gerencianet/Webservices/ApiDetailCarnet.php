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
 * Gerencianet's detail carnet class
 *
 * Implements how to use Gerencianet's detail carnet
 *
 * @package Gerencianet
 */
class ApiDetailCarnet extends ApiBase {

  /**
   * Carnet id to detail
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
    $this->setUrl('/carnet/detail');
  }

  /**
   * Set carnet id
   *
   * @param  integer $id
   * @return ApiDetailCarnet
   */
  public function carnetId($id) {
    $this->_carnetId = $id;
    return $this;
  }

  /**
   * Get carnet id
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
   * @return ApiDetailCarnet
   */
  public function mapData() {
    $this->_data['carnet_id'] = $this->_carnetId;

    return $this;
  }
}
