<?php
namespace Drupal\render_form_in_template\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;

class StudentForm extends FormBase {
 
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'tmp_student_form';
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
      $form['age'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Age'),
        '#required' => TRUE,
        '#maxlength' => 20,
        '#default_value' => '',
      ];
       $form['marks'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Marks'),
        '#required' => TRUE,
        '#maxlength' => 20,
        '#default_value' => '',
      ];
      
      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#button_type' => 'primary',
        '#default_value' => $this->t('Save') ,
      ];
      
      $form['#theme'] = 'students_add_form';
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

    $get_path_update = explode("/", \Drupal::service('path.current')->getPath());

    $field = $form_state->getValues();

    $re_url = Url::fromRoute('render_form_in_template.add_student');

    $fields["fname"] = $field['fname'];
    $fields["sname"] = $field['sname'];
    $fields["age"] = $field['age'];
    $fields["marks"] = $field['marks'];

    \Drupal::messenger()->addMessage($this->t('Student data=fname='.$fields["fname"].'=sname='.$fields["sname"].'=age='.$fields["age"].'marks==='.$fields["marks"]));
    
    $form_state->setRedirectUrl($re_url);


}

}