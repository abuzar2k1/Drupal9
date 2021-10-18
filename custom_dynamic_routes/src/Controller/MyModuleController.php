<?php
namespace Drupal\custom_dynamic_routes\Controller;

use Drupal\Core\Controller\ControllerBase;


class MyModuleController extends ControllerBase {

  /**
   * @return string[]
   */
  public function index() {
    return [
      '#markup' => 'Welcome to custom generated route.',
    ];
  }

}