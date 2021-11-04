<?php

namespace Drupal\custom_access_check_on_route\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Builds an example page.
 */
class ExampleController {

    public function content() {
        return [
            '#type' => 'markup',
            '#markup' => 'Hello! This is custom access route checking.'
        ];

    }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account) {
    // Check permissions and combine that with any custom access checking needed. Pass forward
    // parameters from the route and/or request as needed.
    return AccessResult::allowedIf($account->hasPermission('my custom permission'));
  }

}