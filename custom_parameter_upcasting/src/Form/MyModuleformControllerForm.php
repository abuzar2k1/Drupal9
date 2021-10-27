<?php

namespace Drupal\custom_parameter_upcasting\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;

/**
 * Class MyForm.
 */
class MyModuleformControllerForm extends FormBase {


    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'paramconver_form_id';
    }
  
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $my_menu = NULL) {
  
        

      $form['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#description' => $this->t('Enter your fullname'),
        '#maxlength' => 64,
        '#default_value' => "Node object loaded - ".$my_menu->title->value,
        '#size' => 64,
        '#weight' => '0',
      ];
      
  
      return $form;
    }
  
    /**
     * {@inheritdoc}
     */
    /*public function validateForm(array &$form, FormStateInterface $form_state) {
      parent::validateForm($form, $form_state);
    }*/
  
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      // Display result.
      foreach ($form_state->getValues() as $key => $value) {
        \Drupal::messenger()->addMessage($key . ': ' . $value);
      }
  
    }
  
  }