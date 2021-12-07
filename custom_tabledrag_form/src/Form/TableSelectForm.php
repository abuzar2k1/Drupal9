<?php

namespace Drupal\custom_tabledrag_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TableSelectForm.
 */
class TableSelectForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tabledrag_form_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $group_class = 'group-order-weight';
    $items = [
      1 => [
        'id' => 2,
        'label' => $this->t('Label 1'),
        'weight' => 1,
      ],
      2 => [
        'id' => 5,
        'label' => $this->t('Label 2'),
        'weight' => 2,
      ],
      3 => [
        'id' => 56,
        'label' => $this->t('Label 3'),
        'weight' => 3,
      ],
    ];
  
    // Build table.
    $form['items'] = [
      '#type' => 'table',
      '#caption' => $this->t('Items'),
      '#header' => [
        $this->t('Label'),
        $this->t('ID'),
        $this->t('Weight'),
      ],
      '#empty' => $this->t('No items.'),
      '#tableselect' => FALSE,
      '#tabledrag' => [
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => $group_class,
        ]
      ]
    ];
  
    // Build rows.
    foreach ($items as $key => $value) {
      $form['items'][$key]['#attributes']['class'][] = 'draggable';
      $form['items'][$key]['#weight'] = $value['weight'];
  
      // Label col.
      $form['items'][$key]['label'] = [
        '#plain_text' => $value['label'],
      ];
  
      // ID col.
      $form['items'][$key]['id'] = [
        '#plain_text' => $value['id'],
      ];
  
      // Weight col.
      $form['items'][$key]['weight'] = [
        '#type' => 'weight',
        '#title' => $this->t('Weight for @title', ['@title' => $value['label']]),
        '#title_display' => 'invisible',
        '#default_value' => $value['weight'],
        '#attributes' => ['class' => [$group_class]],
      ];
    }
  
    // Form action buttons.
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
  
    return $form;
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    echo '<pre>';
    print_r($form_state->getValues());
    //die;

  }

}