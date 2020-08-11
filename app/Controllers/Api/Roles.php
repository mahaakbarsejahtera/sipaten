<?php

namespace App\Controllers\Api;

use App\Models\RolesModel;
use CodeIgniter\Controller;

class Roles extends Controller
{

    public function __construct() {
        
    }

    public function index()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];
        

        
        $rolesModel = new RolesModel();

        $response['data'] = [ 
            'lists'     => $rolesModel->paginate(10, 'group1'),
            'per_page'  => $rolesModel->pager,
        ];

        return $this->response->setJson($response);
    }

    public function store()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [
            'role_name'     => 'required',
            'role_cap'      => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'role_name'     => $this->request->getPost('role_name'),
            'role_cap'      => $this->request->getPost('role_cap'),
            'role_desc'     => $this->request->getPost('role_desc'),
        ];

        $rolesModel = new RolesModel;
        $rolesModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $rolesModel->getInsertID();
        //$response['data'] = $insertData;
        $response['message']    = 'Insert Success';

        return $this->response->setJson($response);



    }

    public function udpate($id)
    {
        
    }

    public function delete($id)
    {

    }

    public function destroy()
    {

    }

    public function changePassword() 
    {

    }

}