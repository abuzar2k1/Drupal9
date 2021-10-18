<?php
namespace Drupal\custom_form_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class HelloBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /*return [
      '#markup' => $this->t('Hello, World!'),
    ];*/

    $form = \Drupal::formBuilder()->getForm('Drupal\custom_form_block\Form\MyForm');

    return $form;

  }

}