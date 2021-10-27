<?php

namespace Drupal\custom_parameter_upcasting\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
//use Drupal\custom_parameter_upcasting\Entity\Contact;
use Drupal\node\Entity\Node;
use Symfony\Component\Routing\Route;

class CustomParamConverter implements ParamConverterInterface{

    public function convert($value, $definition, $name, array $defaults){

        /*echo '<pre>';
        print_r(Node::load($value));
        die;*/

        return Node::load($value);
        //return Node::load($value);    // can be load node object also
    }

    public function applies($definition, $name, Route $route){

        return(
            !empty($definition['type']) && ($definition['type'] == 'my_menu')
        );
    }

}