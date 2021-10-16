<?php

/**
 * @file
 * Contains Drupal\custom_config_form\Form\CustomSettingsForm.
 */

namespace Drupal\custom_config_form\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\custom_config_form\Form
 */
class CustomSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_config_form.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_config_form.settings');
    $form['name'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Enter your name'),
      '#default_value' => $config->get('name'),
    );
    return parent::buildForm($form, $form_state);
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
    parent::submitForm($form, $form_state);

    $this->config('custom_config_form.settings')
      ->set('name', $form_state->getValue('name'))
      ->save();
  }

}

/**
 * Get value of config form fields
 * 
 * $config = \Drupal::config('custom_config_form.settings');
 * $config->get('name')
 * 
 */