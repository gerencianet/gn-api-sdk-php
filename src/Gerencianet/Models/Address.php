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
 * Gerencianet's address class
 *
 * Class that abstract and return item array as required for api
 * @package Gerencianet
 */
class Address {

  /**
   * Street name
   *
   * @var string
   */
  private $_street;

  /**
   * Number reference
   *
   * @var string
   */
  private $_number;

  /**
   * Address complement
   *
   * @var string
   */
  private $_complement;

  /**
   * Neighborhood name
   *
   * @var string
   */
  private $_neighborhood;

  /**
   * City name
   *
   * @var string
   */
  private $_city;

  /**
   * Brazilian zipcode
   *
   * @var string
   */
  private $_zipcode;

  /**
   * Brazilian state
   *
   * @var string
   */
  private $_state;

  /**
   * Set value of street
   *
   * @param  string $street
   * @return Address
   */
   public function street($street) {
    $this->_street = $street;
    return $this;
   }

  /**
   * Gets the value of street
   *
   * @return string
   */
  public function getStreet() {
    return $this->_street;
  }

  /**
   * Set value of number
   *
   * @param  string $number
   * @return Address
   */
  public function number($number) {
    $this->_number = $number;
    return $this;
  }

  /**
   * Gets the value of number
   *
   * @return string
   */
  public function getNumber() {
    return $this->_number;
  }

  /**
   * Set value of complement
   *
   * @param  string $complement
   * @return Address
   */
  public function complement($complement) {
    $this->_complement = $complement;
    return $this;
  }

  /**
   * Gets the value of complement
   *
   * @return string
   */
  public function getComplement() {
    return $this->_complement;
  }

  /**
   * Set value of neighborhood
   *
   * @param  string $neighborhood
   * @return Address
   */
  public function neighborhood($neighborhood) {
    $this->_neighborhood = $neighborhood;
    return $this;
  }

  /**
   * Gets the value of neighborhood
   *
   * @return string
   */
  public function getNeighborhood() {
    return $this->_neighborhood;
  }

  /**
   * Set value of city
   *
   * @param  string $city
   * @return Address
   */
  public function city($city) {
    $this->_city = $city;
    return $this;
  }

  /**
   * Gets the value of city
   *
   * @return string
   */
  public function getCity() {
    return $this->_city;
  }

  /**
   * Set value of zipcode
   *
   * @param  string $zipcode
   * @return Address
   */
  public function zipcode($zipcode) {
    $this->_zipcode = str_replace([' ', '.', '-'], '', $zipcode);
    return $this;
  }

  /**
   * Gets the value of zipcode
   *
   * @return string
   */
  public function getZipcode() {
    return $this->_zipcode;
  }

  /**
   * Set value of state
   *
   * @param  string $state
   * @return Address
   */
  public function state($state) {
    $this->_state = strtoupper($state);
    return $this;
  }

  /**
   * Gets the value of state
   *
   * @return string
   */
  public function getState() {
    return $this->_state;
  }

  /**
   * Return an array to be used in Gerencianet's webservices
   *
   * @return array
   */
  public function toArray() {
    $arr = [];

    if($this->_street) {
      $arr['street'] = $this->_street;
    }

    if($this->_zipcode) {
      $arr['zipcode'] = $this->_zipcode;
    }

    if($this->_complement) {
      $arr['complement'] = $this->_complement;
    }

    if($this->_neighborhood) {
      $arr['neighborhood'] = $this->_neighborhood;
    }

    if($this->_city) {
      $arr['city'] = $this->_city;
    }

    if($this->_state) {
      $arr['state'] = $this->_state;
    }

    if($this->_number) {
      $arr['number'] = $this->_number;
    }

    return $arr;
  }
}
