<?php

namespace Drupal\custom_attach_library\Controller;
use Drupal\Core\Controller\ControllerBase;

class AttachJsCss extends ControllerBase {

    public function attachJsCss() {
        return array(
                '#title' => 'Hello attach World!',
                '#markup' => 'Here is some content.',
            );
    }
    
}