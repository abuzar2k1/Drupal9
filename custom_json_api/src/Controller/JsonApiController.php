<?php
namespace Drupal\custom_json_api\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Entity;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

class JsonApiController extends ControllerBase {

    public function listingAll(){

        $nids = \Drupal::entityQuery('node')
			->condition('type', 'article')
			->condition('status', 1)
			->execute();
			
		foreach ($nids as $nid) {
			
			$node = \Drupal\node\Entity\NODE::load($nid);
			$data[] = [
				'title' => $node->title->value,
				//'image' => file_create_url($node->field_hdc_image->entity->getFileUri()),
				'id' => $nid,
			];
			
		}

        /*
        // Hospitals Taxonomy Terms
		$vid = 'hospitals';
		$terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
		foreach ($terms as $term) {
		  $term_obj = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($term->tid);
		  $hospital[] = [
			'tid' => $term->tid,
			'tname' => $term->name,
			//'contact' => $term_obj->get('field_hospital_phone')->value,
			'image' => file_create_url($term_obj->get('field_hospital_image')->entity->getFileUri()),
		  ];
		}

        $container = array(
			'isSuccess' => 'True',
			'code' => '200',
			'message' => 'Home Api',
			//'data' => [ 'Home' => $data, 'Hospitals' => $hospital, 'Doctors' => $doctor, 'Clinics' => $clinic ]
			'data' => [ 'Home' => $data, 'Hospitals' => $hospital, 'Doctors' => $doctor ]
		);

        */

        $container = array(
			'isSuccess' => 'True',
			'code' => '200',
			'message' => 'Article Api',
			'data' => [ 'Article' => $data ]
		);

		return new JsonResponse( $container );

    }


    function articleDetails (Request $request) {
	
        $input = json_decode( $request->getContent(), TRUE );
        $id = $input['id']; // posted value from postman { "id":"5" }
        
        $node = \Drupal\node\Entity\NODE::load($id);
        $data = [
            'title' => $node->title->value,
            //'image' => file_create_url($node->field_hdc_image->entity->getFileUri()),
            'id' => $id,
        ];
		
        $container = array(
            'isSuccess' => 'True',
            'code' => '200',
            'message' => 'Article Details',
            'data' => $data
        );
        
        return new JsonResponse( $container );
        
      }
}