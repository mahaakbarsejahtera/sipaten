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
            'code'      => 0, 
            'message'   => ''
        ];
        

        
        $userModel = new UsersModel();

        $response['data'] = [
            'lists'     => $userModel->paginate(20),
            'per_page'  => $userModel->pager,
        ];

        return $this->response->setJson($response);
    }

    public function store()
    {

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

}