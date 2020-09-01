<?php

namespace App\Controllers\Api;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Users extends Controller
{

    public function __construct() {
        
    }

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new usersModel)
            ->builder()
            ->join('roles', 'users.user_role=roles.id_role', 'left')
            ->join('divisi', 'users.user_divisi=divisi.id_divisi', 'left')
            ->find( $id );

        if($find) {
            $response['data']       = $find;
            $response['code']       = 200;
            $response['message']    = 'Success';
        }

        return $this->response->setJson($response);

    }

    public function index()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];
        


        
        $usersModel = new UsersModel();
        $usersModel->builder()->join('roles', 'users.user_role=roles.id_role', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $usersModel->like('users.user_fullname', $filter['value'])
                            ->orLike('users.user_name', $filter['value'])
                            ->orLike('users.user_email', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($usersModel->filterby))) {
                        $usersModel->where($usersModel->filterby[$filter['key']], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $usersModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $usersModel->paginate(10, 'group1');
        $pager = $usersModel->pager;
        
        $data = [];
        
        foreach($lists as $list) 
        {
            $data[] = $list; 
        }

        $response['data']['lists'] = $data;
        $response['data']['pagination'] = $pager->links('group1', 'bootstrap_pagination');
        

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
            'user_name'         => 'required',
            'user_fullname'     => 'required',
            'user_email'        => 'required',
            'user_role'         => 'required',
            //'user_code'         => 'required',
            //'user_divisi'         => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'user_name'         => (string)$this->request->getPost('user_name'),
            'user_role'         => (int)$this->request->getPost('user_role'),
            'user_fullname'     => (string)$this->request->getPost('user_fullname'),
            'user_email'        => (string)$this->request->getPost('user_email'),
            'user_status'       => (string)$this->request->getPost('user_status'),
            'user_pass'         => (string)md5('ymdhis'),
            'user_code'         => (string)$this->request->getPost('user_code'),
            //'user_divisi'         => $this->request->getPost('user_divisi')
        ];

        $user_image = $this->request->getFile('user_image');

        if(!empty($user_image->getTempName())) {
            $name = $user_image->getRandomName();
            $uploaded_file = $user_image->move('uploads/users/', $name);
            $insertData['user_image'] = (string)$name;
        }

        $this->response->setJSON($insertData);

        $usersModel = new UsersModel;
        $usersModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Insert Success';

        return $this->response->setJson($response);



    }

    public function update()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [
            'id_user'           => 'required',
            'user_name'         => 'required',
            'user_fullname'     => 'required',
            'user_email'        => 'required',
            'user_email'        => 'required',
            'user_role'         => 'required',
            //'user_divisi'       => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_user'           => $this->request->getPost('id_user'),
            'user_name'         => $this->request->getPost('user_name'),
            'user_role'         => $this->request->getPost('user_role'),
            'user_fullname'     => $this->request->getPost('user_fullname'),
            'user_email'        => $this->request->getPost('user_email'),
            'user_status'       => $this->request->getPost('user_status'),
            'user_pass'         => md5('ymdhis'),
            'user_code'         => $this->request->getPost('user_code'),
            //'user_divisi'       => $this->request->getPost('user_divisi'),
        ];

        $user_image = $this->request->getFile('user_image');
        if(!empty($user_image->getTempName())) {
            $name = $user_image->getRandomName();
            $uploaded_file = $user_image->move('uploads/users/', $name);
            $insertData['user_image'] = $name;
        }

        $usersModel = new UsersModel;
        $usersModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $this->request->getPost('id_role');
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
    }

    public function delete($id)
    {
        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new usersModel)->find( $id );
        if($find) {

            (new usersModel)->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        

        return $this->response->setJson($response);
    }

    public function destroy()
    {

    }

    public function changePassword() 
    {

        
        $response = [
            'data'      => [],
            'errors'    => [],
            'code'      => 0,
            'message'   => ''
        ];


        $rules = [
            'id_user'      => 'required',
            'user_pass' => 'required',
        ];

        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }


        $insertData = [
            'id_user' => $this->request->getPost('id_user'),
            'user_pass' => md5($this->request->getPost('user_pass'))
        ];

        (new usersModel)->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);

    }

}