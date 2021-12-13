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
class ConfigFirstForm extends FormBase {
 
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dn_first_form';
  }
 
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    
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
	
	  //$config = \Drupal::service('config.factory')->getEditable('pass_value_one_form_to_another.settings');
		//$config->set('fname', $form_state->getValue('fname'))->save();

    /*$config = \Drupal::service('config.factory')->getEditable('pass_value_one_form_to_another.settings');
    $config
      ->set('fname', $form_state->getValue('fname'))
      ->set('sname', $form_state->getValue('sname'))
      ->save();*/

      $config_factory = \Drupal::configFactory();
      $config = $config_factory->getEditable('pass_value_one_form_to_another.settings');
      $config->set('names', [$form_state->getValue('fname'), $form_state->getValue('sname')]);
      $config->save(TRUE);

		  $form_state->setRedirectUrl(Url::fromUri('internal:/' . 'configsecondform'));
  
  }
 
}