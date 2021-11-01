<?php

namespace Drupal\custom_permissions\Controller;

class CustomPermission {

    public function mypermission() {
        
        return array(
                '#title' => 'my custom permission',
                '#markup' => 'my custom permission',
            );
    }

}