<?php

namespace Drupal\attach_js_css\Controller;
use Drupal\Core\Controller\ControllerBase;

class AttachJsCss extends ControllerBase {

    public function attachJsCss() {
        return array(
                '#title' => 'Hello attach World!',
                '#markup' => 'Here is some content.',
            );
    }
    
}