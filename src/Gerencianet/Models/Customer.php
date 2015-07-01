<?php

namespace Gerencianet\Models;

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
   * Brazilian document for natural person
   *
   * @var string
   */
  private $_cpf;

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
   * Juridical person data
   *
   * @var JuridicalPerson
   */
  private $_juridicalPerson;

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
   * Set value of brazilian document for natural person
   *
   * @param  string $cpf
   * @return Customer
   */
  public function cpf($cpf) {
    $this->_cpf = str_replace([' ', '.', '-'], '', $cpf);
    return $this;
  }

  /**
   * Gets the value of brazilian document for natural person
   *
   * @return string
   */
  public function getCpf() {
    return $this->_cpf;
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
   * Set value of juridical person
   *
   * @param  JuridicalPerson $juridicalPerson
   * @return Customer
   */
  public function juridicalPerson(JuridicalPerson $juridicalPerson) {
    $this->_juridicalPerson = $juridicalPerson;
    return $this;
  }

  /**
   * Get the value of juridical person
   *
   * @return JuridicalPerson
   */
  public function getJuridicalPerson() {
    return $this->_juridicalPerson;
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

    if($this->_cpf) {
      $arr['cpf'] = $this->_cpf;
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

    if($this->_juridicalPerson) {
      $arr['juridical_person'] = $this->_juridicalPerson->toArray();
    }

    return $arr;
  }
}
