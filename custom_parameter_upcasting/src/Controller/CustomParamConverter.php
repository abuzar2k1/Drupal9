<?php

namespace Drupal\custom_parameter_upcasting\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines CustomParamConverter class.
 */
class CustomParamConverter extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, custom param converter!'),
    ];
  }

}