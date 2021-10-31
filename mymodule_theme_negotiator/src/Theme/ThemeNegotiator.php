<?php

namespace Drupal\mymodule_theme_negotiator\Theme;

use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\Core\Routing\RouteMatchInterface;

class ThemeNegotiator implements ThemeNegotiatorInterface {
  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {

    //echo '<pre>';
    //print_r($route_match->getRouteName()); die;

    // Use this theme on a certain route.
    return $route_match->getRouteName() == 'view.frontpage.page_1'; // applied on homepage

    // Or use this for more than one route:

    /*$possible_routes = array(
        'entity.taxonomy_term.add_form',
        'entity.taxonomy_term.edit_form'
    );

    return (in_array($route_match->getRouteName(), $possible_routes));*/
    
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    // Here you return the actual theme name.
    return 'bartik';
  }

}