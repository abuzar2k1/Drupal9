<?php
/**
 * @file
 * Contains \Drupal\controller_value_to_hooks_then_js\Controller\TestTwigController.
 */
 
namespace Drupal\controller_value_to_hooks_then_js\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
 
class TestController extends ControllerBase {

  public function content() {
 
    return array(
      '#title' => 'Hello attach World!',
      '#markup' => '<div id="mydiv"><a href="javascript:void(0)" class="testjs">1Here is some content.</a></div>',
  );

}


public function ajaxcallfn($argone, $argtwo){

    $name = $argone.'-'.$argtwo;
    return new JsonResponse($name);
}

}