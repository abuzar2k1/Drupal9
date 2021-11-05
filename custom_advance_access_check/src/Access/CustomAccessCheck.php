<?php

namespace Drupal\custom_advance_access_check\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class CustomAccessCheck implements AccessInterface {

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
    
    return $account->hasPermission('my custom permission') ? AccessResult::allowed() : 
    AccessResult::forbidden();

  }

}