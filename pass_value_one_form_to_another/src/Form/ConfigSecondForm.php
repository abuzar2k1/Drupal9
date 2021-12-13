<?php

namespace Drupal\pass_value_one_form_to_another\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;
 
/**
 * Provides the form for adding countries.
 */
class ConfigSecondForm extends FormBase {
 
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dn_second_form';
  }
 
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
   
	$names = \Drupal::config('pass_value_one_form_to_another.settings')->get('names');

  print_r($names);
  // output Array ( [0] => abu [1] => zar )
  //die;

	$form['description'] = [
      '#type' => 'item',
      '#markup' => $names[0],
    ];
    $form['fname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => '',
    ];
	 $form['sname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Second Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => '',
    ];
	$form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#default_value' => 'Next' ,
    ];
 
    return $form;
 
  }
  
   /**
   * {@inheritdoc}
   */
  public function validateForm(array & $form, FormStateInterface $form_state) {
        //print_r($form_state->getValues());exit;
		
  }
 
  /**
   * {@inheritdoc}
   */
  public function submitForm(array & $form, FormStateInterface $form_state) {
	  //echo "reaches";exit;
 
  }
 
}