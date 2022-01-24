<?php

namespace Drupal\custom_employee\Form;

//use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Utility\Html;
use Drupal\file\Entity\File;
use Drupal\custom_employee\EmployeeStorage;
use Drupal\image\Entity\ImageStyle;
use Drupal\image\Entity\buildUri;
use Drupal\image\Entity\buildUrl;

/**
 * Employee search form.
 */
class EmployeeTableForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_table_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $search_key = \Drupal::request()->query->get('search');

    // Table header.
    $header = [
      ['data' => t('ID'), 'field' => 'e.id'],
      'picture' => '',
      ['data' => t('Name'), 'field' => 'e.name'],
      ['data' => t('Email'), 'field' => 'e.email'],
      ['data' => t('Country'), 'field' => 'e.country'],
      ['data' => t('State'), 'field' => 'e.state'],
      ['data' => t('Status')],
      'actions' => 'Operations',
    ];

    //$limit = 5;

    $query2 = \Drupal::database();
    $query = $query2->select('employee', 'e')
      ->fields('e')
      ->extend('Drupal\Core\Database\Query\TableSortExtender')
      ->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    $query->orderByHeader($header); // sorting header fields

    $config = \Drupal::config('custom_employee.settings'); // setting limit by config form
    $limit = ($config->get('page_limit')) ? $config->get('page_limit') : 10;
    $query->limit($limit);

    if (!empty($search_key)) {
      $query->condition('e.name', "%" .
        Html::escape($search_key) . "%", 'LIKE');
    }
    $results = $query->execute();

    $rows = [];
    foreach ($results as $row) {

      $ajax_link_attributes = [
        'attributes' => [
          'class' => 'use-ajax',
          'data-dialog-type' => 'modal',
          'data-dialog-options' => ['width' => 700, 'height' => 400],
        ],
      ];

      //Syntax
      // use Drupal\Core\Url;
      //Url::fromRoute('module_new', [], ['absolute' => TRUE]);

      $view_url = Url::fromRoute('custom_employee.view',
        ['employee' => $row->id, 'js' => 'nojs']);

      $ajax_view_url = Url::fromRoute('custom_employee.view',
        ['employee' => $row->id, 'js' => 'ajax'], $ajax_link_attributes);

      // convert username into url to show the user details
      $ajax_view_link = Link::fromTextAndUrl($row->name, $ajax_view_url);

      //$view_link = Link::fromTextAndUrl('View', Url::fromRoute('employee.view',
        //['employee' => $row->id, 'js' => 'nojs']));

      $mail_url = Url::fromRoute('custom_employee.sendmail', ['employee' => $row->id],
        $ajax_link_attributes);
        
      $drop_button = [
        '#type' => 'dropbutton',
        '#links' => [

              'view' => [
                'title' => t('View'),
                'url' => $view_url,
              ],
              'edit' => [
                'title' => t('Edit'),
                'url' => Url::fromRoute('custom_employee.edit', ['employee' => $row->id]),
              ],
              'delete' => [
                'title' => t('Delete'),
                'url' => Url::fromRoute('custom_employee.delete', ['id' => $row->id]),
              ],
              'quick_edit' => [
                'title' => t('Quick Edit'),
                'url' => Url::fromRoute('custom_employee.quickedit', ['employee' => $row->id],
                  $ajax_link_attributes),
              ],
              'mail' => [
                'title' => t('Mail'),
                'url' => $mail_url,
              ],
              
        ],
      ];

      $profile_pic = File::load($row->profile_pic);
      if ($profile_pic) {
        
        $style = \Drupal::entityTypeManager()->getStorage('image_style')->load('thumbnail');
        $profile_pic_url = $style->buildUrl($profile_pic->getFileUri());
        
        //echo '<pre>';
        //print_r($profile_pic_url);
        //die;

      }
      else {
        $module_handler = Drupal::service('module_handler');
        $path = $module_handler->getModule('custom_employee')->getPath();
        $profile_pic_url = $base_url . '/' . $path . '/assets/profile_placeholder_thumb.png';
      }

      $rows[$row->id] = [
        [sprintf("%04s", $row->id)],
        'picture' => [
          'data' => [
            '#type' => 'html_tag',
            '#tag' => 'img',
            '#attributes' => ['src' => $profile_pic_url],
          ],
        ],
        [$ajax_view_link],
        [$row->email],
        [$row->country],
        [$row->state],
        [($row->status) ? 'Active' : 'Blocked'],
        'actions' => [
          'data' => $drop_button,
        ],
      ];
    }

    // All selected - active, block and delete
    $form['action'] = [
      '#type' => 'select',
      '#title' => t('Action'),
      '#options' => [
        'delete' => 'Delete Selected',
        'activate' => 'Activate Selected',
        'block' => 'Block Selected',
      ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Apply to selected items',
      '#prefix' => '<div class="form-actions js-form-wrapper form-wrapper">',
      '#suffix' => '</div>',
    ];

    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $rows,
      '#attributes' => [
        'id' => 'employee-contact-table',
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $selected_ids = array_filter($form_state->getValue('table'));


    // array_map

    /*function myfunction($num)
    { 
      return($num*$num); 
    }

    $a=array(1,2,3,4,5);
    print_r(array_map("myfunction",$a));
    output : Array ( [0] => 1 [1] => 4 [2] => 9 [3] => 16 [4] => 25 )*/

    $selected_ids = array_map(function ($val) 
    {
      $record = EmployeeStorage::load($val);
      return $record->name;
    }, $selected_ids);

    if (!array_filter($selected_ids)) {
      \Drupal::messenger()->addMessage(t('No employee record to selected'), 'error');
      $form_state->setRedirect('employee.list');
      return;
    }
    else 
    {
      $request = \Drupal::request(); // getting form request type - get, post
      
      $session = $request->getSession();
      $session->set('custom_employee', [
        'selected_items' => $selected_ids,
      ]);

      $form_state->setRedirect('custom_employee.action', ['action' => $form_state->getValue('action')]);
      return;
    }

    
  }

}
