<?php

/**
 * @file
 * Contains Drupal\custom_form_block\Form\SettingsForm.
 */

namespace Drupal\custom_form_block\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\custom_form_block\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_form_block.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_form_block.settings');
    $form['bio'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Bio'),
      '#default_value' => $config->get('bio'),
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

    $this->config('custom_form_block.settings')
      ->set('bio', $form_state->getValue('bio'))
      ->save();
  }

}