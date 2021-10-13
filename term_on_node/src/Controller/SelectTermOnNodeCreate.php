<?php
namespace Drupal\term_on_node\Controller;
use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Drupal\file\Entity\File;

class SelectTermOnNodeCreate extends ControllerBase{

    public function createNode() {

        // Create file object from remote URL.
        /*$data = file_get_contents('https://www.drupal.org/files/druplicon.small_.png');
        $file = file_save_data($data, 'public://druplicon.png', FILE_EXISTS_REPLACE);*/

        $node = Node::create(array(
            'type' => 'new_content_type',
            'title' => 'First content with code',
            'uid' => '1',
            'status' => 1,
            //'created' => $data[$dateIndex],
            //'field_autor' => $data[$autorIndex],
            //'field_teaser_text' => $data[$shortIndex],

            /*'field_image' => [
                'target_id' => $file->id(),
                'alt' => 'Hello world',
                'title' => 'Goodbye world'
            ],*/

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