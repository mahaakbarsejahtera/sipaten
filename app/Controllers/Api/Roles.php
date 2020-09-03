<?php

namespace App\Controllers\Api;

use App\Models\RolesModel;
use CodeIgniter\Controller;

class Roles extends Controller
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

        $find = (new RolesModel)
            ->builder()
            ->find( $id );

        $find = $find + [
            'jenis_pengajuan' =>  (new RolesModel)->getjenisPengajuan($id)
        ];

        if($find) {
            $response['data']       = $find;
            $response['code']       = 200;
            $response['message']    = 'Success';
        }

        return $this->response->setJson($response);

    }

    public function index()
    {
        
        $no_limit   = $this->request->getGet('no_limit');
        $pager      = "";
        $lists      = [];
        $data       = [];

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];
        


        
        $rolesModel = new RolesModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $rolesModel->like('roles.role_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($rolesModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                        $rolesModel->where($rolesModel->filterby[$filter['key']], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $rolesModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $rolesModel->paginate(10, 'group1');
        $pager = $rolesModel->pager;

        if($no_limit) 
        {

            $lists                          = $rolesModel->findAll();

        } 
        else 
        {

            $lists                          = $rolesModel->paginate(10, 'group1');

            $pager                          = $rolesModel->pager;
            $response['data']['pagination'] = $pager->links('group1', 'bootstrap_pagination');

        }   

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

        $db = db_connect(); 
        $rolesModel = $db->table('roles');
        $rolesModel->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_role' => $db->insertID() ] + $insertData;
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
            'id_role'       => 'required',
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
            'id_role'       => $this->request->getPost('id_role'),
            'role_name'     => $this->request->getPost('role_name'),
            'role_cap'      => $this->request->getPost('role_cap'),
            'role_desc'     => $this->request->getPost('role_desc'),
        ];

        $rolesModel = new RolesModel;
        $rolesModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
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

        $find = (new rolesModel)->find( $id );
        if($find) {

            (new rolesModel)->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        return $this->response->setJson($response);
    }

    
    public function saveJenisPengajuan() 
    {

        $response = [
            'code'          => 0,
            'message'       => '',
            'data'          => [],
            'errors'        => []
        ];

        $rules = [
            'id_role'               => 'required',
            'id_jenis_pengajuan'    => 'required',
        ];

        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $id_role             = $this->request->getPost('id_role');
        $ids_jenis_pengajuan = $this->request->getPost('id_jenis_pengajuan');

        $db = db_connect();

        $builder = $db->table('roles_pengajuan');

        $builder->where('id_role', $id_role)->delete();

        foreach($ids_jenis_pengajuan as $id_jenis_pengajuan) $builder->insert(['id_role' => $id_role, 'id_jenis_pengajuan' => $id_jenis_pengajuan]);

        $response = [
            'code'      => 200,
            'message'   => 'Success',
            'data'      => [],
            'errors'    => []
        ];

        return $this->response->setJSON($response);

    }


}