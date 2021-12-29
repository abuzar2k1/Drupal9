<?php

namespace Drupal\custom_form_block\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Class MyForm.
 */
class MyForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_form_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = \Drupal::config('custom_form_block.settings');

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Enter your fullname'),
      '#default_value' => $config->get('bio'),  // getting admin setting form value from /admin/config/custom_form_block/settings
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

    $form['file'] = [
      '#type' => 'managed_file',
      '#title' => t('File'),
      '#upload_location' => 'public://file',
      '#upload_validators' => [
        'file_validate_extensions' => ['png'],
      ],
      //'#default_value' => array(2)  // "2" here is the file id
    ];

    // multiple file upload
    $form['upload']['image_dir'] = [

      '#type'                 => 'managed_file',
      '#upload_location'      => 'public://',
      '#multiple'             => TRUE,
      '#description'          => t('Allowed extensions: gif png jpg jpeg'),
      '#upload_validators'    => [
        'file_validate_is_image'      => array(),
        'file_validate_extensions'    => array('gif png jpg jpeg'),
        'file_validate_size'          => array(25600000)
      ],
      '#title'                => t('Upload an image file for this slide')

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

    $fid = $form_state->getValue(['file', 0]);
    if (!empty($fid)) {

      $file = File::load($fid);
      $file->setPermanent();
      $file->save();

      $filename = $file->getFilename();
    }

    // multiple file upload
    $file_data = $form_state->getValue(['upload' => 'image_dir']);
    //$file = \Drupal\file\Entity\File::load( $file_data[0] );
    $file = File::load( $file_data[0] );
    $file_name = $file->getFilename();
    $file->setPermanent();
    $file->save();

    //Here we will get file name which we can save it in our table.
    //$file_data will be an array which contains file id. If multiple files are selected , 
    //then multiple values will be there in this array.

    //print_r($file_data);
    //die;
    //output Array ( [0] => 8 [1] => 9 [2] => 10 )

    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . $value);
    }

  }

}