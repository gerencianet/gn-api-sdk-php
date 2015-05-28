<?php

namespace Gerencianet\Models;
use \Exception;

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
 * Gerencianet's Exception class
 *
 * Class that process the exceptions
 * @package Gerencianet
 */
class GerencianetException extends Exception {

  /**
   * Construct method
   */
  public function __construct($exception) {
    $message = isset($exception['error_description']['message']) ? $exception['error_description']['message'] : $exception['error_description'];

    if(isset($exception['error_description']['property'])) {
      $message .= ': ' . $exception['error_description']['property'];
    }

    parent::__construct($message, $exception['code']);
  }

  /**
   * Return the error code concatenated with the error message
   *
   * @return string
   */
  public function toString() {
    return 'Error ' . $this->code .': ' . $this->message . "\n";
  }
}