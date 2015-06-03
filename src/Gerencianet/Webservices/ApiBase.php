<?php

namespace Gerencianet\Webservices;
use Gerencianet\Models\GerencianetException;

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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

/**
 * Gerencianet's abstract base class
 *
 * Abstract class that implements cURL
 * @package Gerencianet
 */
abstract class ApiBase {

  /**
   * Define API Gerencianet URL
   */
  const BASE_URL = 'https://api.gerencianet.com.br/v1';

  /**
   * Define Gerencianet test URL
   */
  const BASE_TEST_URL = 'https://sandbox.gerencianet.com.br/v1';

  /**
   * Define URL to get access token
   *
   * @var string
   */
  private $_accessTokenUrl;

  /**
   * Enable/disable test api
   *
   * @var boolean
   */
  private $_isTest = false;

  /**
   * Final URL to send the cURL
   *
   * @var string
   */
  protected $_url;

  /**
   * Data to be sent to Gerencianet
   *
   * @var mixed
   */
  protected $_data;

  /**
   * Webservice's response
   *
   * @var array
   */
  protected $_response;

  /**
   * User's client id
   *
   * @var boolean
   */
  protected $_clientId;

  /**
   * User's secret key
   *
   * @var string
   */
  protected $_clientSecret;

  /**
   * User's access token
   *
   * @var string
   */
  protected $_accessToken = null;

  /**
   * Expiration time access token
   *
   * @var integer
   */
  protected $_expirationAccessToken;

  /**
   * Guzzle client
   *
   * @var GuzzleHttp\Client
   */
  protected $_guzzleClient;

  /**
   * Method construct
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  protected function __construct($clientId, $clientSecret, $isTest = false) {
    $this->_guzzleClient = new Client();
    $this->_clientId = $clientId;
    $this->_clientSecret = $clientSecret;
    $this->_isTest = $isTest;
    $this->_response = null;
  }

  /**
   * Get a new access token
   *
   * @return ApiBase
   */
  public function getAccessToken() {
    $this->send(true);

    if(isset($this->_response['error']) && $this->_response['error'] == "invalid_client") {
      $error = [
        'code' => 401,
        'error_description' => 'Invalid keys to get the access token.'
      ];

      throw new GerencianetException($error);
    } else {
      $this->_accessToken = $this->_response['access_token'];
      $this->_expirationAccessToken = time() + $this->_response['expires_in'];

      return $this;
    }
  }

  /**
   * Set URL to reach Gerencianet
   *
   * @param string  $url
   */
  protected function setUrl($url) {
    if(!$this->_isTest) {
      $this->_url = self::BASE_URL . $url;
      $this->_accessTokenUrl = self::BASE_URL . '/authorize';
    } else {
      $this->_url = self::BASE_TEST_URL . $url;
      $this->_accessTokenUrl = self::BASE_TEST_URL . '/authorize';
    }
  }

  /**
   * Get the data and the access token to send to Gerencianet
   *
   * @return ApiBase An instance of ApiBase
   */
  public function run() {
    $this->mapData();

    // Veriry if the access token is valid. If not, get a new access token
    if(!$this->_expirationAccessToken || $this->_expirationAccessToken <= time()) {
      $this->getAccessToken();
    }

    $this->send();

    // If the access token is invalid, get a new access token and sends the data again
    if(isset($this->_response->error) && $this->_response->error == 'invalid_token') {
      $this->getAccessToken();
      $this->send();
    }

    return $this;
  }

  /**
   * Send data to Gerencianet and wait it's response using cURL
   *
   * @param boolean $isAccessToken
   */
  protected function send($isAccessToken = false) {
    // If it is to get the access token, define the send data and the correct URL
    if($isAccessToken) {
      $_data = [
      'grant_type' => 'client_credentials',
      'client_id' => $this->_clientId,
      'client_secret' => $this->_clientSecret
      ];

      $url = $this->_accessTokenUrl;
    } else {
      $_data = json_encode($this->_data);

      $_data = array("access_token" => $this->_accessToken, "data" => $_data);

      $url = $this->_url;
    }

    try {
      $request = $this->_guzzleClient->createRequest('POST', $url, ['body' => $_data]);
      $response = $this->_guzzleClient->send($request);

      $this->_response = $response->json();

      if(isset($this->_response['code']) && $this->_response['code'] != 200) {
        throw new GerencianetException($this->_response);
      }

    } catch(ClientException $clientException) {
      $this->_response = $clientException->getResponse()->json();
    } catch(ServerException $serverException) {
      throw new GerencianetException($serverException->getResponse()->json());
    } catch(RequestException $requestException) {
      $error = [
        'code' => 503,
        'error_description' => 'Without access to the API.'
      ];
      throw new GerencianetException($error);
    }

    if(!$this->_response) {
      $error = [
        'code' => 503,
        'error_description' => 'Without access to the API.'
      ];
      throw new GerencianetException($error);
    }
  }

  /**
   * Get webservice's response as array
   *
   * @return array
   */
  public function response() {
    return $this->_response;
  }

  /**
   * Sets the value of guzzleClient
   *
   * @param Client $guzzleClient
   */
  public function guzzleClient($guzzleClient) {
    $this->_guzzleClient = $guzzleClient;
  }

  /**
   * Get the value of guzzle client
   *
   * @return Client $guzzleClient
   */
  public function getGuzzleClient() {
    return $this->_guzzleClient;
  }

  /**
   * Abstract method that maps the sending data
   *
   * @return ApiBase An instance of ApiBase
   */
  public abstract function mapData();

}
