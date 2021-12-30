<?php

namespace Drupal\custom_crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database;

/**
 * Class MyForm.
 */
class MyFormCrud extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_crudform_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    //$config = \Drupal::config('hello_world.settings');

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Enter your fullname'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      '#description' => $this->t('Enter your phone number'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Enter your email'),
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $postdata = $form_state->getValues();

    // Display result.
    /*foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . $value);
    }*/

    unset($postdata['submit'],$postdata['form_build_id'],$postdata['form_token'],$postdata['form_id'],$postdata['op'],$postdata['field_message']);

    $query = \Drupal::database();
    $query->insert('employee_1')->fields($postdata)->execute();

    \Drupal::messenger()->addMessage('saved successfully.','status',TRUE);

  }

}