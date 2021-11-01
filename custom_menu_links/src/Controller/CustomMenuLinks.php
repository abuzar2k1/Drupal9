<?php

namespace Drupal\custom_menu_links\Controller;

class CustomMenuLinks {

    public function mylink() {
        
        return array(
                '#title' => 'my custom menu',
                '#markup' => 'my custom menu',
            );
    }

}