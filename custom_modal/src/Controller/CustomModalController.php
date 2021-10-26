<?php

/**
 * @file
 * CustomModalController class.
 */

namespace Drupal\custom_modal\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;

class CustomModalController extends ControllerBase {

  public function modal() {

    $options = [
      'dialogClass' => 'popup-dialog-class',
      'width' => '50%',
    ];
    
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand(t('Modal title'), t('The modal text'), $options));
    
    return $response;
  }
}