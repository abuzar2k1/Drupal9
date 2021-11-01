<?php

namespace Drupal\custom_tabs_on_user_node\Controller;

class CustomTabs {

    public function tabone() {
        
        return array(
                '#title' => 'tabone',
                '#markup' => 'tabone',
            );
    }

    public function tabtwo() {
        
        return array(
                '#title' => 'tabtwo',
                '#markup' => 'tabtwo',
            );
    }

    public function tabthree() {
        
        return array(
                '#title' => 'tabthree',
                '#markup' => 'tabthree',
            );
    }

    public function tabuser() {
        
        return array(
                '#title' => 'tab user',
                '#markup' => 'tab user',
            );
    }

    public function nodeviewfn() {
        
        return array(
                '#title' => 'node view',
                '#markup' => 'node view',
            );
    }
}