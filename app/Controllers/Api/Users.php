<?php

namespace App\Controllers\Api;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Users extends Controller
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
        

        
        $userModel = new UsersModel();

        $response['data'] = [ 
            'lists'     => $userModel->paginate(20, 'group1'),
            'per_page'  => $userModel->pager,
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


        $this->validate([
            'user_name'     => 'required',
            'user_fullname' => 'required',
            'user_email'    => 'required',
            'user_status'   => 'required'
        ]);

        if(!$this->validate->withRequest($this->request)->run())
        {
            $response['code'] = 400;
            $response['message'] = 'Bad Request';
            $response['errors'] = $this->validator->getErrors();
            return $this->response->setJson($response);
        }

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