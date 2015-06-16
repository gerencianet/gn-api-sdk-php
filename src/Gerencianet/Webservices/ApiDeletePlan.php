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
 * Gerencianet's delete plan class
 *
 * Implements how to use Gerencianet's delete plan
 *
 * @package Gerencianet
 */
class ApiDeletePlan extends ApiBase {

  /**
   * Plan id to delete
   *
   * @var integer
   */
  private $_planId;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/plan/delete');
  }

  /**
   * Set plan id
   *
   * @param  integer $id
   * @return ApiDeletePlan
   */
  public function planId($planId) {
    $this->_planId = $planId;
    return $this;
  }

  /**
   * Get plan id
   *
   * @return integer
   */
  public function getPlanId() {
    return $this->_planId;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiDeletePlan
   */
  public function mapData() {
    $this->_data['plan_id'] = $this->_planId;

    return $this;
  }
}
