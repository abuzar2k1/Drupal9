<?php
namespace Drupal\term_on_node\Controller;
use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SelectTermOnNodeCreate extends ControllerBase{

    public function createNode() {

        $node = Node::create(array(
            'type' => 'new_content_type',
            'title' => 'First content with code',
            'uid' => '1',
            'status' => 1,
            //'created' => $data[$dateIndex],
            //'field_autor' => $data[$autorIndex],
            //'field_teaser_text' => $data[$shortIndex],
            'field_selectfruit'  => [   // ATTACHING TERMS WITH NODE
              ['target_id' => 2], ['target_id' => 3]
            ]
        ));
        $node->save();

        if($node->id() != '') {
            \Drupal::messenger()->addMessage('Node Created successfully.','status',TRUE);
            
            $response = new RedirectResponse('/drupaltut/employee-list');
            $response->send();
        }

    }

}