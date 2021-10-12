<?php
/**
 * @file
 * Contains \Drupal\test_twig\Controller\TestTwigController.
 */
 
namespace Drupal\custom_twig_module\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class TestTwigController extends ControllerBase {
  public function content() {
 
    $output = ['apple', 'mango', 'orange'];
    return [
      '#theme' => 'my_template',
      //'#test_var' => $this->t('Test Value'),
      '#test_var' => $output,
    ];
 
  }

  public function contentsecond() {
 
    $output = ['apple', 'mango', 'orange'];
    return [
      '#theme' => 'my_template',
      //'#test_var' => $this->t('Test Value'),
      '#test_var' => $output,
    ];
 
  }
}