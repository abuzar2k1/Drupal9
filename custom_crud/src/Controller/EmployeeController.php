<?php

namespace Drupal\custom_crud\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployeeController extends ControllerBase{
    
    public function getEmployeeList() {
        
        /*$service = \Drupal::service('custom_service.custom_services');
        print_r($service->getServiceData());
        die;*/

        $limit = 3;

        $query = \Drupal::database();
        $result = $query->select('employee_1', 'e')
                ->fields('e', ['id', 'name', 'phone', 'email'])
                ->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit($limit)    // pagination
                ->execute()->fetchAll(\PDO::FETCH_OBJ);
                
        $data = [];

        $params = \Drupal::request()->query->all();
        //print_r($params);

        foreach($result as $row){

            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
                'phone' => $row->phone,
                'Edit' => t("<a href='edit-employee/$row->id'>Edit</a>"),
                'Delete' => t("<a href='delete-employee/$row->id'>Delete</a>"),
            ];
        }

        $header = array('id','name', 'phone', 'Edit', 'Delete');

        $build['table'] = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $data,
        ];

        $build['pager'] = [
            '#type' => 'pager',
        ];

        return [
            $build, 
            '#title' => 'Employee List'
            ];
    }

    public function deleteEmployee($id){

        $query = \Drupal::database()->delete('employee_1');
        $query->condition('id', $id);
        $query->execute();

        $response = new RedirectResponse('../employee-list');
        $response->send();
    
        \Drupal::messenger()->addMessage('Record Deleted successfully.','status',TRUE);

    }

}