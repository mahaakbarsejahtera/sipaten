<?php

namespace App\Controllers\Api;

use App\Models\DivisiModel;
use CodeIgniter\Controller;

class Divisi extends Controller
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

        $find = (new DivisiModel)->find( $id );

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
        


        
        $divisiModel = new DivisiModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $divisiModel->like('roles.role_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($divisiModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                        $divisiModel->where($divisiModel->filterby[$filter['key']], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $divisiModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $divisiModel->paginate(10, 'group1');
        $pager = $divisiModel->pager;

        $response['data']['lists'] = $lists;
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
            'nama_divisi'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_divisi'     => $this->request->getPost('id_divisi'),
            'nama_divisi'   => $this->request->getPost('nama_divisi'),
        ];

        $db = db_connect();
        $divisiModel = $db->table('divisi');
        $divisiModel->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_divisi' => $db->insertID() ] + $insertData;
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
            'id_divisi'       => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_divisi'       => $this->request->getPost('id_divisi'),
            'nama_divisi'     => $this->request->getPost('nama_divisi'),
        ];

        $divisiModel = new DivisiModel;
        $divisiModel->save($insertData);

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

        $find = (new DivisiModel)->find( $id );
        if($find) {

            (new DivisiModel)->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        return $this->response->setJson($response);
    }

   
}