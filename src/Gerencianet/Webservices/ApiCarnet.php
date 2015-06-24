<?php

namespace Gerencianet\Webservices;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\Carnet;

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
 * Gerencianet's carnet class
 *
 * Implements how to use Gerencianet's carnet
 *
 * @package Gerencianet
 */
class ApiCarnet extends ApiBase {

  /**
   * Set of items for this carnet
   *
   * @var array
   */
  private $_items;

  /**
   * Customer's attributes
   *
   * @var Customer
   */
  private $_customer;

  /**
   * Metadata's attributes
   *
   * @var Metadata
   */
  private $_metadata;

  /**
   * Expiration date of first carnet's charge
   *
   * @var string
   */
  private $_expireAt;

  /**
   * Number of charges in the carnet
   *
   * @var integer
   */
  private $_repeats;

  /**
   * If the value must be split among all carnet's charges
   *
   * @var boolean
   */
  private $_splitItems;

  /**
   * Post office service for this carnet
   *
   * @var PostOfficeService
   */
  private $_postOfficeService;

  /**
   * Set of instructions for this carnet
   *
   * @var array
   */
  private $_instructions;

  /**
   * Emission rate of carnet
   *
   * @var integer
   */
  private $_carnetRate;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/carnet');
    $this->_items = [];
    $this->_instructions = [];
  }

  /**
   * Add a new item to the set of items
   *
   * @param  Item $item
   * @return ApiCarnet
   */
  public function addItem($item) {
    $this->_items[] = $item->toArray();
    return $this;
  }

  /**
   * Add a array of new items to the set of items
   *
   * @param  Array $items
   * @return ApiCarnet
   */
  public function addItems(Array $items) {
    foreach($items as $item) {
      $this->_items[] = $item->toArray();
    }
    return $this;
  }

  /**
   * Get items of carnet
   *
   * @return array
   */
  public function getItems() {
    return $this->_items;
  }

  /**
   * Set a customer of carnet
   *
   * @param  Customer $customer
   * @return ApiCarnet
   */
  public function customer(Customer $customer) {
    $this->_customer = $customer;
    return $this;
  }

  /**
   * Get the customer of carnet
   *
   * @return Customer
   */
  public function getCustomer() {
    return $this->_customer;
  }

  /**
   * Set a metadata of carnet
   *
   * @param  Metadata $metadata
   * @return ApiCarnet
   */
  public function metadata(Metadata $metadata) {
    $this->_metadata = $metadata;
    return $this;
  }

  /**
   * Get metadata of carnet
   *
   * @return Metadata
   */
  public function getMetadata() {
    return $this->_metadata;
  }

  /**
   * Set the value of expire at
   *
   * @param  string $expireAt
   * @return ApiCarnet
   */
  public function expireAt($expireAt) {
    $expireAt = str_replace('/', '-', $expireAt);
    $this->_expireAt = date("Y-m-d", strtotime($expireAt));
    return $this;
  }

  /**
   * Gets the value of expire at
   *
   * @return string
   */
  public function getExpireAt() {
    return $this->_expireAt;
  }

  /**
   * Set value of repeats
   *
   * @param  integer $repeats
   * @return ApiCarnet
   */
  public function repeats($repeats) {
    $this->_repeats = $repeats;
    return $this;
  }

  /**
   * Gets the value of repeats
   *
   * @return integer
   */
  public function getRepeats() {
    return $this->_repeats;
  }

  /**
   * Set value of split items
   *
   * @param  boolean $splitItems
   * @return ApiCarnet
   */
  public function splitItems($splitItems) {
    $this->_splitItems = $splitItems;
    return $this;
  }

  /**
   * Gets the value of split items
   *
   * @return boolean
   */
  public function getSplitItems() {
    return $this->_splitItems;
  }

  /**
   * Set the value of post office service
   *
   * @param  PostOfficeService $postOfficeService
   * @return ApiCarnet
   */
  public function postOfficeService($postOfficeService) {
    $this->_postOfficeService = $postOfficeService;
    return $this;
  }

  /**
   * Get the value of post office service
   *
   * @return PostOfficeService
   */
  public function getPostOfficeService() {
    return $this->_postOfficeService;
  }

  /**
   * Add a new instruction to the set of instructions
   *
   * @param  string $instruction
   * @return ApiCarnet
   */
  public function addInstruction($instruction) {
    $this->_instructions[] = $instruction;
    return $this;
  }

  /**
   * Add a array of new instructions to the set of instructions
   *
   * @param  string $instructions
   * @return ApiCarnet
   */
  public function addInstructions(Array $instructions) {
    $this->_instructions = array_merge($this->_instructions, $instructions);
    return $this;
  }

  /**
   * Get instructions of carnet
   *
   * @return array
   */
  public function getInstructions() {
    return $this->_instructions;
  }

  /**
   * Set the emission rate of carnet
   *
   * @param  integer $carnetRate
   * @return ApiCarnet
   */
  public function carnetRate($carnetRate) {
    $this->_carnetRate = $carnetRate;
    return $this;
  }

  /**
   * Get the emission rate of carnet
   *
   * @return integer
   */
  public function getCarnetRate() {
    return $this->_carnetRate;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiCarnet
   */
  public function mapData() {
    $this->_data['items'] = $this->_items;

    if($this->_customer) {
      $this->_data['customer'] = $this->_customer->toArray();
    }

    $this->_data['repeats'] = $this->_repeats;

    if($this->_expireAt) {
      $this->_data['expire_at'] = $this->_expireAt;
    }

    if(is_bool($this->_splitItems)) {
      $this->_data['split_items'] = $this->_splitItems;
    }

    if($this->_postOfficeService) {
      $postOfficeService = $this->_postOfficeService->toArray();

      if(!empty($postOfficeService)) {
        $this->_data['post_office_service'] = $postOfficeService;
      }
    }

    if($this->_metadata) {
      $metadata = $this->_metadata->toArray();

      if(!empty($metadata)) {
        $this->_data['metadata'] = $metadata;
      }
    }

    if($this->_instructions) {
      $this->_data['instructions'] = $this->_instructions;
    }

    if($this->_carnetRate) {
      $this->_data['carnet_rate'] = $this->_carnetRate;
    }

    return $this;
  }
}
