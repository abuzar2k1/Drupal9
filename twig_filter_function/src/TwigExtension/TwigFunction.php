<?php
namespace Drupal\twig_filter_function\TwigExtension;
/**
 * Class TwigFunction.
 */
class TwigFunction extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * @return string
   */

  public function getName() {
    return 'twig_filter_function.function';
  }

  /**
   * Declare your custom twig extension here
   *
   * @return array|\Twig_SimpleFunction[]
   */
  public function getFunctions() {

    return [
      new \Twig_SimpleFunction('display_block_by_id', [$this, 'display_block'],['is_safe' => ['html']]
      )
    ];

  }
  /**
   * Function to get and render block by id
   * @param $block_id
   *  Block id to render
   *
   * @return array
   */
  public function display_block($block_id) {
    $block = \Drupal\block\Entity\Block::load($block_id);
    return \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view($block);
  }
  
}