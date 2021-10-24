<?php

namespace Drupal\batch_process_node_by_json\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;

/**
 * Provides a form for deleting a batch_process_node_by_json entity.
 *
 * @ingroup batch_process_node_by_json
 */
class MyForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return 'batch_process_node_by_json_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#prefix'] = '<p>This example form will import nodes from the json/animals.json example</p>';

    $form['actions'] = array(
      '#type' => 'actions',
      'submit' => array(
        '#type' => 'submit',
        '#value' => 'Proceed',
      ),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    /*$host = \Drupal::request()->getHost();
    $url = $host . '/' . drupal_get_path('module', 'batch_process_node_by_json') . '/json/animals.json';
    $request = \Drupal::httpClient()->get($url);*/

    $module_handler = \Drupal::service('module_handler');
    $url = $module_handler->getModule('batch_process_node_by_json')->getPath() . '/json/animals.json';
    
    $fname = file_get_contents($url);
    $data = json_decode($fname, TRUE);
    $total = count($data);

    $batch = [
    'title' => t('Importing nodes'),
    'operations' => [],
    'init_message' => t('Import process is starting.'),
    'progress_message' => t('Processed @current out of @total. Estimated time: @estimate.'),
    'error_message' => t('The process has encountered an error.'),
    ];

    foreach($data as $item) {
      $batch['operations'][] = [['\Drupal\batch_process_node_by_json\Form\MyForm', 'callbackFunction'], [$item]];
    }

    batch_set($batch);
    \Drupal::messenger()->addMessage('Imported ' . $total . ' node(es)!');

    $form_state->setRebuild(TRUE);
  }

  /**
   * @param $entity
   * Deletes an entity
   */
  public function callbackFunction($item, &$context) {
    $entity = Node::create([
        'type' => 'article',
        'langcode' => 'und',
        'title' => $item['name'],
      ]
    );
    $entity->save();
    $context['results'][] = $item['name'];
    $context['message'] = t('Created @title', array('@title' => $item['name']));
  }

}