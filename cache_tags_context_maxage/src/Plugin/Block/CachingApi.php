<?php
namespace Drupal\cache_tags_context_maxage\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CachingApi' Block.
 *
 * @Block(
 *   id = "cachingapi_block",
 *   admin_label = @Translation("CachingApi block"),
 *   category = @Translation("CachingApi World"),
 * )
 */
class CachingApi extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {

    $randString = rand(500, 1000);

    return [

      '#markup' => $randString,
      '#cache' => [
        'tags' => [
          'node-list', // invalidating
        ],
        'contexts' => [
          'url',
        ],
        'max-age' => 10,
      ],

    ];

  }

}