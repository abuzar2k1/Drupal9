<?php

namespace Drupal\custom_employee\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\custom_employee\EmployeeStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;

/**
 * Employee email form.
 */
class EmployeeMailForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_mail_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form,
  FormStateInterface $form_state,
    $employee = NULL) {
    if ($employee) {
      if ($employee == 'invalid') {
        \Drupal::messenger()->addMessage(t('Invalid employee record'), 'error');
        return new RedirectResponse(Url::fromRoute('custom_employee.list')->toString());
      }
      $form['eid'] = [
        '#type' => 'hidden',
        '#value' => $employee->id,
      ];
    }

    $form['#prefix'] = '<div id="employee_mail_form">';
    $form['#suffix'] = '</div>';

    // The status messages that will contain any form errors.
    $form['status_messages'] = [
      '#type' => 'status_messages',
      '#weight' => -10,
    ];

    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => t('Subject'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Send',
      '#attributes' => [
        'class' => [
          'use-ajax',
        ],
      ],
      '#ajax' => [
        'callback' => '::sendMailAjax',
        'event' => 'click',
      ],
    ];

    $form['actions']['cancel'] = [
      '#type' => 'link',
      '#title' => 'Cancel',
      '#attributes' => ['class' => ['button']],
      '#url' => Url::fromRoute('custom_employee.list'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function sendMailAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    // If there are any form errors, re-display the form.
    if ($form_state->hasAnyErrors()) {
      $response->addCommand(new ReplaceCommand('#employee_mail_form', $form));
    }
    else {
      $id = $form_state->getValue('eid');
      if (!empty($id) && EmployeeStorage::exists($id)) {
        $employee = EmployeeStorage::load($id);
        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'custom_employee';
        $key = 'send_employee_mail';
        $to = $employee->email;
        $params['subject'] = $form_state->getValue('subject');
        $params['message'] = $form_state->getValue('message');
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = TRUE;
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
        \Drupal::messenger()->addMessage(t('Email sent sucessfully'));
        $form_state->setRedirect('custom_employee.list');
        $response->addCommand(new RedirectCommand(Url::fromRoute('custom_employee.list')->toString()));
      }
    }
    return $response;
  }

}
