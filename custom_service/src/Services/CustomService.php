<?php

namespace Drupal\custom_service\Services;

/**
 * Class CustomService.
 */
class CustomService {

  /**
   * Constructs a new CustomService object.
   */
  /*public function __construct() {

  }*/

  public function getServiceData() {
    //Do something here to get any data.

    return [
        'orange' => 'orange',
        'mango' => 'mango',
        'apple' => 'apple',
    ];

  }
  /**
   * Here you can pass your values as $array.
   */
  public function postServiceData($array) {
    //Do something here to post any data.
  }
}


/*

And for accessing service in your module file

$service = \Drupal::service('custom_service.custom_services');
$service->getServiceData();
*/