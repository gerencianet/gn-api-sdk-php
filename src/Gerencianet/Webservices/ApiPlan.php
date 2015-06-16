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
 * Gerencianet's plan class
 *
 * Implements how to use Gerencianet's plan
 *
 * @package Gerencianet
 */
class ApiPlan extends ApiBase {

  /**
   * Plan's name
   *
   * @var string
   */
  private $_name;

  /**
   * Interval, in months, that the charges must be created
   *
   * @var string
   */
  private $_interval;

  /**
   * How many times a charge must be created
   *
   * @var integer
   */
  private $_repeats;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/plan');
  }

  /**
   * Set plan's name
   *
   * @param  string $name
   * @return ApiPlan
   */
  public function name($name) {
    $this->_name = $name;
    return $this;
  }

  /**
   * Get plan's name
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set plan's repeats
   *
   * @param  string $repeats
   * @return ApiPlan
   */
  public function repeats($repeats) {
    $this->_repeats = $repeats;
    return $this;
  }

  /**
   * Get plan's repeats
   *
   * @return string
   */
  public function getRepeats() {
    return $this->_repeats;
  }

  /**
   * Set plan's interval
   *
   * @param  string $interval
   * @return ApiPlan
   */
  public function interval($interval) {
    $this->_interval = $interval;
    return $this;
  }

  /**
   * Get plan's interval
   *
   * @return string
   */
  public function getInterval() {
    return $this->_interval;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiPlan
   */
  public function mapData() {

    $this->_data['name']     = $this->_name;
    $this->_data['repeats']  = $this->_repeats;
    $this->_data['interval'] = $this->_interval;

    return $this;
  }

}
