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
 * Gerencianet's customer class
 *
 * Class that abstract and return customer attributes as required for api
 * @package Gerencianet
 */
class Customer {

  /**
   * Customer's name
   *
   * @var string
   */
  private $_name;

  /**
   * Brazilian document
   * @var string
   */
  private $_document;

  /**
   * Customer's email
   *
   * @var string
   */
  private $_email;

  /**
   * Customer's birth. The required format is 'YYYY-mm-dd'
   *
   * @var string
   */
  private $_birth;

  /**
   * Customer's phone number
   *
   * @var string
   */
  private $_phoneNumber;

  /**
   * Customer's address
   *
   * @var Address
   */
  private $_address;

  /**
   * Set value of name
   *
   * @param  string $name
   * @return Customer
   */
  public function name($name) {
    $this->_name = $name;
    return $this;
  }

  /**
   * Gets the value of name
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set value of brazilian document
   *
   * @param  string $document
   * @return Customer
   */
  public function document($document) {
    $this->_document = str_replace([' ', '.', '-'], '', $document);
    return $this;
  }

  /**
   * Gets the value of brazilian document
   *
   * @return string
   */
  public function getDocument() {
    return $this->_document;
  }

  /**
   * Set the value of email
   *
   * @param  string $email
   * @return Customer
   */
  public function email($email) {
    $this->_email = $email;
    return $this;
  }

  /**
   * Gets the value of email
   *
   * @return string
   */
  public function getEmail() {
    return $this->_email;
  }

  /**
   * Set value of birth. The required format is 'YYYY-mm-dd'
   *
   * @param  string $birth
   * @return Customer
   */
  public function birth($birth) {
    $birth = str_replace('/', '-', $birth);
    $this->_birth = date('Y-m-d', strtotime($birth));
    return $this;
  }

  /**
   * Gets the value of birth
   *
   * @return string
   */
  public function getBirth() {
    return $this->_birth;
  }

  /**
   * Set value of phone number
   *
   * @param  string $phoneNumber
   * @return Customer
   */
  public function phoneNumber($phoneNumber) {
    $this->_phoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);
    return $this;
  }

  /**
   * Gets the value of phone
   *
   * @return string
   */
  public function getPhoneNumber() {
    return $this->_phoneNumber;
  }

  /**
   * Set value of address
   *
   * @param  Address $address
   * @return Customer
   */
  public function address(Address $address) {
    $this->_address = $address;
    return $this;
  }

  /**
   * Get the value of address
   *
   * @return Address
   */
  public function getAddress() {
    return $this->_address;
  }

  /**
   * Get mapped customer to be used in Gerencianet's api
   *
   * @return array
   */
  public function toArray() {
    $arr = [];

    if($this->_name) {
      $arr['name'] = $this->_name;
    }

    if($this->_document) {
      $arr['document'] = $this->_document;
    }

    if($this->_email) {
      $arr['email'] = $this->_email;
    }

    if($this->_birth) {
      $arr['birth'] = $this->_birth;
    }

    if($this->_phoneNumber) {
      $arr['phone_number'] = $this->_phoneNumber;
    }

    if($this->_address) {
      $arr['address'] = $this->_address->toArray();
    }

    return $arr;
  }
}
