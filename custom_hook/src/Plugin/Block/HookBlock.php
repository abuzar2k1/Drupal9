<?php
namespace Drupal\custom_hook\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'CustomHook' Block.
 *
 * @Block(
 *   id = "customhook_block",
 *   admin_label = @Translation("CustomHook block"),
 *   category = @Translation("CustomHook World"),
 * )
 */
class HookBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $moduleHandler;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ModuleHandlerInterface $module_handler)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->moduleHandler = $module_handler;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){

    return new static(
      $configuration,
      $plugin_id, 
      $plugin_definition,
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    
    $query = \Drupal::entityQuery('node')
           ->condition('type', 'article')
           ->sort('nid', 'DESC')
           ->range(0,5);
    $list = $query->execute();

    // Debug.
    dump($query->execute());
    //dump($query->sqlQuery->__toString());

    $this->moduleHandler->invokeAll('get_all_nodes', [$list]);
    $this->moduleHandler->alter('get_all_nodes', $list);

    $list_string = implode(", ", $list);

    return [
      '#markup' => '<marquee>'.$list_string.'</marquee>',
      '#allowed_tags' => ['marquee'],
    ];

  }

}