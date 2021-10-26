<?php

namespace Drupal\modal_form_example\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;

/**
 * ModalFormExampleController class.
 */
class ModalFormExampleController extends ControllerBase {

  /**
   * Callback for opening the modal form.
   */
  public function openModalForm() {

    // Get the modal form using the form builder.
    $modal_form = \Drupal::formBuilder()->getForm('Drupal\custom_form_block\Form\MyForm');

    // Add an AJAX command to open a modal dialog with the form as the content.
    //$response->addCommand(new OpenModalDialogCommand('My Modal Form', $modal_form, ['width' => '800']));

    return $modal_form;
  }

}

/**
 * Use
 * <a class="use-ajax" data-dialog-type="modal" href="mymodule/modal_form">Open ModalBox</a>
 */