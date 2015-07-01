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
 * Gerencianet's juridical person class
 *
 * Class that abstract and return juridical person attributes as required for api
 * @package Gerencianet
 */
class JuridicalPerson {

  /**
   * Corporate name
   *
   * @var string
   */
  private $_corporateName;

  /**
   * Brazilian document for juridical person
   *
   * @var string
   */
  private $_cnpj;

  /**
   * Set value of corporate name
   *
   * @param  string $corporateName
   * @return JuridicalPerson
   */
  public function corporateName($corporateName) {
    $this->_corporateName = $corporateName;
    return $this;
  }

  /**
   * Gets the value of corporate name
   *
   * @return string
   */
  public function getCorporateName() {
    return $this->_corporateName;
  }

  /**
   * Set value of brazilian document for juridical person
   *
   * @param  string $cnpj
   * @return JuridicalPerson
   */
  public function cnpj($cnpj) {
    $this->_cnpj = str_replace([' ', '.', '-', '/'], '', $cnpj);
    return $this;
  }

  /**
   * Gets the value of brazilian document for juridical person
   *
   * @return string
   */
  public function getCnpj() {
    return $this->_cnpj;
  }

  /**
   * Get mapped juridical person to be used in Gerencianet's api
   *
   * @return array
   */
  public function toArray() {
    $arr = [];

    if($this->_corporateName) {
      $arr['corporate_name'] = $this->_corporateName;
    }

    if($this->_cnpj) {
      $arr['cnpj'] = $this->_cnpj;
    }

    return $arr;
  }
}