<?php

namespace Drupal\custom_employee\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
//use Drupal\Component\Utility\SafeMarkup;  // deprecated with new HTML::escape()
use Drupal\Component\Utility\HTML;
use Drupal\Core\Url;
use Drupal\custom_employee\EmployeeStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\custom_employee\Event\EmpWelcomeEvent;
use Drupal\file\Entity\File;

/**
 * Employee search form.
 */
class EmployeeForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_add';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $employee = NULL) {

    /* $employee (ParamConverter)
    Drupal\custom_employee\ParamConverter\EmployeeParamConverter*/

    /*echo '<pre>';
    print_r($employee->id);
    die;*/
    
    if ($employee) {
      if ($employee == 'invalid') {
        drupal_set_message(t('Invalid employee record'), 'error');
        return new RedirectResponse(Drupal::url('employee.list'));
      }
      $form['eid'] = [
        '#type' => 'hidden',
        '#value' => $employee->id,
      ];
    }

    $form['#attributes']['novalidate'] = '';
    $form['general'] = [
      '#type' => 'details',
      "#title" => "General Details",
      '#open' => TRUE,
    ];

    $form['general']['name'] = [
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#required' => TRUE,
      '#default_value' => ($employee) ? $employee->name : '',
    ];

    $form['general']['email'] = [
      '#type' => 'email',
      '#title' => t('Email'),
      '#required' => TRUE,
      '#default_value' => ($employee) ? $employee->email : '',
    ];

    $form['general']['department'] = [
      '#type' => 'select',
      '#title' => t('Department'),
      '#options' => [
          '' => 'Select Department',
          'Development' => 'Development',
          'HR' => 'HR',
          'Sales' => 'Sales',
          'Marketing' => 'Marketing',
      ],
      '#required' => TRUE,
      '#default_value' => ($employee) ? $employee->department : '',
    ];

    $form['general']['status'] = [
      '#type' => 'checkbox',
      '#title' => t('Active?'),
      '#default_value' => ($employee) ? $employee->status : 1,
    ];

    $form['address_details'] = [
      '#type' => 'details',
      "#title" => "Address Details",
      '#open' => TRUE,
    ];

    $form['address_details']['address'] = [
      '#type' => 'textarea',
      '#title' => t('Address'),
      '#required' => TRUE,
      '#default_value' => ($employee) ? $employee->address : '',
    ];

    // country-states
    $form['address_details']['country'] = [
      '#type' => 'select',
      '#title' => t('Country'),
      '#options' => $this->getCountries(),
      //'#required' => TRUE,
      '#default_value' => ($employee) ? $employee->country : '',
      '#ajax' => [
        'callback' => [$this, 'loadStates'],
        'event' => 'change',
        'wrapper' => 'states',
      ],
    ];
    $changed_country = $form_state->getValue('country');
    if ($employee) {
      if (!empty($changed_country)) {
        $selected_country = $changed_country;
      }
      else {
        $selected_country = $employee->country;
      }
    }
    else {
      $selected_country = $changed_country;
    }

    $states = $this->getStates($selected_country);
    $form['address_details']['state'] = [
      '#type' => 'select',
      '#prefix' => '<div id="states">',
      '#title' => t('State'),
      '#options' => $states,
      //'#required' => TRUE,
      '#suffix' => '</div>',
      '#default_value' => ($employee) ? $employee->state : '',
      '#validated' => TRUE,
    ];
    // country-states end

    $form['upload'] = [
      '#type' => 'details',
      "#title" => "Profile Pic",
      '#open' => TRUE,
    ];

    $form['upload']['profile_pic'] = [
      '#type' => 'managed_file',
      '#upload_location' => 'public://employee_images/',
      '#multiple' => FALSE,
      '#upload_validators' => [
        'file_validate_extensions' => ['png gif jpg jpeg jfif'],
        'file_validate_size' => [25600000],
        // 'file_validate_image_resolution' => array('800x600', '400x300'),.
      ],
      '#title' => t('Upload a Profile Picture'),
      '#default_value' => ($employee) ? [$employee->profile_pic] : '',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save',
    ];

    $form['actions']['cancel'] = [
      '#type' => 'link',
      '#title' => 'Cancel',
      '#attributes' => ['class' => ['button', 'button--primary']],
      '#url' => Url::fromRoute('custom_employee.list'),
    ];
    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function loadStates(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);
    return $form['address_details']['state'];
  }

  /**
   * {@inheritdoc}
   */
  public function getCountries() {
    return [
      '' => 'Select Country',
      'India' => 'India',
      'Usa' => "Usa",
      'Russia' => "Russia",
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getStates($selected_country) {
    $states = [
      'India' => [
        '' => 'Select State',
        'Odisha' => 'Odisha',
        'Telangana' => 'Telangana',
        'Gujarat' => 'Gujarat',
        'Rajasthan' => 'Rajasthan',
      ],
      'Usa' => [
        '' => 'Select State',
        'Texas' => 'Texas',
        'Californea' => 'California',
      ],
      'Russia' => [
        '' => 'Select State',
        'Moscow' => 'Moscow',
        'Saints Petesberg' => 'Saints Petesberg',
      ],
    ];
    return ($selected_country) ? $states[$selected_country] : ['' => 'Select State'];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    if (!empty($email) && (filter_var($email,
        FILTER_VALIDATE_EMAIL) === FALSE)) {
      $form_state->setErrorByName('email', t('Invalid email'));
    }
    $id = $form_state->getValue('eid');
    if (!empty($id)) {
      if (!EmployeeStorage::checkUniqueEmail($email, $id)) {
        $form_state->setErrorByName('email', t('This email has already been taken!'));
      }
    }
    else {
      if (!EmployeeStorage::checkUniqueEmail($email)) {
        $form_state->setErrorByName('email', t('The email has already been taken!'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $id = $form_state->getValue('eid');
    $file_usage = \Drupal::service('file.usage');
    $profile_pic_fid = NULL;

    $image = $form_state->getValue('profile_pic');
    if (!empty($image)) {
      $profile_pic_fid = $image[0];
    }


    $fields = [
      'name' => HTML::escape($form_state->getValue('name')),
      'email' => HTML::escape($form_state->getValue('email')),
      'department' => $form_state->getValue('department'),
      'country' => $form_state->getValue('country'),
      'state' => $form_state->getValue('state'),
      'address' => HTML::escape($form_state->getValue('address')),
      'status' => $form_state->getValue('status'),
      'profile_pic' => $profile_pic_fid,
    ];
    
    // Image operation starts
    if (!empty($id) && EmployeeStorage::exists($id)) {
      $employee = EmployeeStorage::load($id);
      if ($profile_pic_fid) {
        if ($profile_pic_fid !== $employee->profile_pic) {

          $file_del = File::load($employee->profile_pic);
          $file_del->delete();
          //file_delete($employee->profile_pic); //deprecated

          $file = File::load($profile_pic_fid);
          $file->setPermanent();
          $file->save();
          $file_usage->add($file, 'employee', 'file', $id);
        }
      }
      else {

        $file_del = File::load($employee->profile_pic);
        $file_del->delete();
        //file_delete($employee->profile_pic);  //deprecated

      }
      EmployeeStorage::update($id, $fields);
      $message = 'Employee updated sucessfully';
    }
    else {
      $new_employee_id = EmployeeStorage::add($fields);
      if ($profile_pic_fid) {
        $file = File::load($profile_pic_fid);
        $file->setPermanent();
        $file->save();
        $file_usage->add($file, 'employee', 'file', $new_employee_id);
      }
      
      $this->dispatchEmpWelcomeMailEvent($new_employee_id); // dispatching Event : below

      $message = 'Employee created sucessfully';
    }
    // Image operation end

    \Drupal::messenger()->addMessage($message,'status',TRUE);
    $form_state->setRedirect('custom_employee.list');

  }

  private function dispatchEmpWelcomeMailEvent($employee_id) {

    $dispatcher = \Drupal::service('event_dispatcher');
    $event = new EmpWelcomeEvent($employee_id);
    $dispatcher->dispatch('custom_employee.welcome.mail', $event);

  }

}
