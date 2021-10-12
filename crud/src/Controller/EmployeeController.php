<?php

namespace Drupal\crud\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployeeController extends ControllerBase{
    
    public function getEmployeeList() {
        
        $limit = 3;

        $query = \Drupal::database();
        $result = $query->select('employee', 'e')
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

        $query = \Drupal::database()->delete('employee');
        $query->condition('id', $id);
        $query->execute();

        $response = new RedirectResponse('../employee-list');
        $response->send();
    
        \Drupal::messenger()->addMessage('Record Deleted successfully.','status',TRUE);

    }

}