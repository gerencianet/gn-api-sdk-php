<?php

namespace Gerencianet\Webservices;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Metadata;

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
 * Gerencianet's subscription class
 *
 * Implements how to use Gerencianet's subscription
 *
 * @package Gerencianet
 */
class ApiSubscription extends ApiBase {

  /**
   * Set of items for this subscription
   *
   * @var array
   */
  private $_cart;

  /**
   * Set of shippings for this subscription
   *
   * @var array
   */
  private $_shippings;

  /**
   * Metadata's attributes
   *
   * @var Metadata
   */
  private $_metadata;

  /**
   * Customer's attributes
   *
   * @var Customer
   */
  private $_customer;

   /**
   * Plan's attributes
   *
   * @var Plan
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
    $this->setUrl('/subscription');
    $this->_cart = [];
    $this->_shippings = [];
    $this->_metadata = new Metadata();
  }

  /**
   * Add a new item to the set of items
   *
   * @param  Item $item
   * @return ApiSubscription
   */
  public function addItem($item) {
    $this->_cart[] = $item->toArray();
    return $this;
  }

  /**
   * Add a array of new items to the set of items
   *
   * @param  Array $items
   * @return ApiSubscription
   */
  public function addItems(Array $items) {
    foreach($items as $item) {
      $this->_cart[] = $item->toArray();
    }
    return $this;
  }

  /**
   * Get items of subscription
   *
   * @return array
   */
  public function getItems() {
    return $this->_cart;
  }

  /**
   * Add a new shipping to the set of shippings
   *
   * @param  Shipping $shipping
   * @return ApiSubscription
   */
  public function addShipping($shipping) {
    $this->_shippings[] = $shipping->toArray();
    return $this;
  }

  /**
   * Add a array of new shippings to the set of shippings
   *
   * @param  Array $shippings
   * @return ApiSubscription
   */
  public function addShippings(Array $shippings) {
    foreach($shippings as $shipping) {
      $this->_shippings[] = $shipping->toArray();
    }
    return $this;
  }

  /**
   * Get shippings of subscription
   *
   * @return array
   */
  public function getshippings() {
    return $this->_shippings;
  }

  /**
   * Set a metadata of subscription
   *
   * @param  Metadata $metadata
   * @return ApiSubscription
   */
  public function metadata(Metadata $metadata) {
    $this->_metadata = $metadata;
    return $this;
  }

  /**
   * Get metadata of subscription
   *
   * @return Metadata
   */
  public function getMetadata() {
    return $this->_metadata;
  }

  /**
   * Set a customer of subscription
   *
   * @param  Customer $customer
   * @return ApiSubscription
   */
  public function customer(Customer $customer) {
    $this->_customer = $customer;
    return $this;
  }

  /**
   * Get the customer of subscription
   *
   * @return Customer
   */
  public function getCustomer() {
    return $this->_customer;
  }

  /**
   * Set plan of subscription
   *
   * @param  Plan $plan
   * @return ApiSubscription
   */
  public function planId($planId) {
    $this->_planId = $planId;
    return $this;
  }

  /**
   * Get plan of subscription
   *
   * @return Plan
   */
  public function getPlanId() {
    return $this->_planId;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBase::mapData()
   * @return ApiSubscription
   */
  public function mapData() {
    $this->_data['items'] = $this->_cart;

    if($this->_shippings) {
      $this->_data['shippings'] = $this->_shippings;
    }

    if($this->_metadata) {
      $metadata = $this->_metadata->toArray();

      if(!empty($metadata)) {
        $this->_data['metadata'] = $metadata;
      }
    }

    if($this->_customer) {
      $this->_data['customer'] = $this->_customer->toArray();
    }

    $this->_data['plan_id'] = $this->_planId;

    return $this;
  }
}
