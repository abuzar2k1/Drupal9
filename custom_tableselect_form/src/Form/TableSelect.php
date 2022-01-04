<?php

namespace Drupal\custom_tableselect_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database;

/**
 * Class TableSelect.
 */
class TableSelect extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tableselect_form_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $query = \Drupal::database()->select('users_field_data', 'u');
    $query->fields('u', ['uid','name','mail']);
    $results = $query->execute()->fetchAll();

    $header = [
      'userid' => t('User id'),
      'Username' => t('username'),
      'email' => t('Email'),
    ];

    // Initialize an empty array
    $output = array();

    // Next, loop through the $results array
    foreach ($results as $result) {
        if ($result->uid != 0 && $result->uid != 1) {
          $output[$result->uid] = [
            'userid' => $result->uid,     // 'userid' was the key used in the header
            'Username' => $result->name, // 'Username' was the key used in the header
            'email' => $result->mail,    // 'email' was the key used in the header
          ];
        }
    }

    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('No users found'),
    ];

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    
    /*$users = array(
      array('uid' => 1, 'first_name' => 'Indy', 'last_name' => 'Jones'),
      array('uid' => 2, 'first_name' => 'Darth', 'last_name' => 'Vader'),
      array('uid' => 3, 'first_name' => 'Super', 'last_name' => 'Man'),
    );
  
    $header = array(
      'first_name' => t('First Name'),
      'last_name' => t('Last Name'),
    );

    $options = array();
    foreach ($users as $user) {
      $options[$user['uid']] = array(
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
      );
    }

    $form['table'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No users found'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );*/

    return $form;
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.

    //$selected_ids = array_filter($form_state->getValue('table'));
    $postdata = $form_state->getValues();
    echo '<pre>';
    print_r($postdata);
    die;
    echo '<pre>';
    print_r($postdata['table']);

    foreach($postdata['table'] as $k=>$v){
      echo $k.'====='.$v;
      echo '<br>';
    }
    die;

  }

}