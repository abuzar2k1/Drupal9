<?php

namespace Drupal\custom_employee\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;
use Drupal\custom_employee\EmployeeStorage;

/**
 * Param converter for url param of type {employee}.
 */
class EmployeeParamConverter implements ParamConverterInterface {

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    if (!EmployeeStorage::exists($value)) {
      return 'invalid';
    }

    /*echo '<pre>';
      print_r(EmployeeStorage::load($value));
      die;*/

    return EmployeeStorage::load($value);
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {

    return (!empty($definition['type']) && $definition['type'] == 'employee');
    
  }

}
