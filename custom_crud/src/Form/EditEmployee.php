<?php

namespace Drupal\custom_crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class MyForm.
 */
class EditEmployee extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'edit_employee_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    //$config = \Drupal::config('hello_world.settings');

    $id = \Drupal::routeMatch()->getParameter('id');

    $query = \Drupal::database();
    $data = $query->select('employee_1', 'e')
            ->fields('e', ['id', 'name', 'phone', 'email'])
            ->condition('e.id', $id, '=')
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

    //print_r($data);
    //Array ( [0] => stdClass Object ( [id] => 1 [name] => a1 [phone] => 1234567890 [email] => a@a.com ) )

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Enter your fullname'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#default_value' => $data[0]->name,
    ];
    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      '#description' => $this->t('Enter your phone number'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#default_value' => $data[0]->phone,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Enter your email'),
      '#weight' => '0',
      '#default_value' => $data[0]->email,
    ];
    $form['update'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
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
    $id = \Drupal::routeMatch()->getParameter('id');


    // Display result.
    /*foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . $value);
    }*/

    unset($postdata['update'],$postdata['form_build_id'],$postdata['form_token'],$postdata['form_id'],$postdata['op']);

    $query = \Drupal::database();
    $query->update('employee_1')
            ->fields($postdata)
            ->condition('id', $id)
            ->execute();

    $response = new RedirectResponse('../employee-list');
    $response->send();

    \Drupal::messenger()->addMessage('Record Updated successfully.','status',TRUE);

  }

}