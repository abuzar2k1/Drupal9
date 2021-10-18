<?php

namespace Drupal\custom_form_block\Controller;

class HelloWorldController {
    public function hello() {
        return array(
                '#title' => 'Hello World!',
                '#markup' => 'Here is some content.',
            );
    }
}