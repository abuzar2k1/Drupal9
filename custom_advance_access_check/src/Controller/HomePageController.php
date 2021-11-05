<?php

namespace Drupal\custom_advance_access_check\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Builds an example page.
 */
class HomePageController {

    public function content() {
        return [
            '#type' => 'markup',
            '#markup' => 'Hello! This is advance access check.'
        ];

    }

}