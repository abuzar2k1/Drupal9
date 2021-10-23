<?php

namespace Drupal\twig_filter_function\TwigExtension;

use Twig_Extension;
use Twig_SimpleFilter;

class TwigFilter extends \Twig_Extension  {

  /**
   * This is the same name we used on the services.yml file
   */
  public function getName() {
    return 'twig_filter_function.filter';
  }

  // Basic definition of the filter. You can have multiple filters of course.
  public function getFilters() {
    return [
      new Twig_SimpleFilter('word_count', [$this, 'wordCountFilter']),
    ];
  }

  // The actual implementation of the filter.
  public function wordCountFilter($context) {
    if(is_string($context)) {
      $context = str_word_count($context);
    }
    return $context;
  }
}

/**
 * 
 * use the filter in your templates.

*   {{ "shuffle me!" | word_count }} {# Return 2. #} 

 */