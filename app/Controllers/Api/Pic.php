<?php

namespace App\Controllers\Api;

use App\Models\PicModel;
use CodeIgniter\Controller;

class Pic extends Controller
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

        $find = (new PicModel)->find( $id );

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
        


        
        $picModel = new PicModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $picModel->like('pic.nama_pic', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($picModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                        $picModel->where($filter['key'], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $picModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $picModel->paginate(10, 'group1');
        $pager = $picModel->pager;

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
            'id_customer'       => 'required',
            'nama_pic'          => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_customer'   => (int)$this->request->getPost('id_customer'),
            'nama_pic'      => (string)$this->request->getPost('nama_pic'),
            'divisi_pic'    => (string)$this->request->getPost('divisi_pic'),
            'jabatan_pic'   => (string)$this->request->getPost('jabatan_pic'),
            'kontak_pic'    => (string)$this->request->getPost('kontak_pic')
        ];

        $picModel = new PicModel;
        $picModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $picModel->getInsertID();
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
            'id_customer'       => 'required',
            'nama_customer'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pic'        => (int)$this->request->getPost('id_pic'),
            'id_customer'   => (int)$this->request->getPost('id_customer'),
            'nama_pic'      => (string)$this->request->getPost('nama_pic'),
            'divisi_pic'    => (string)$this->request->getPost('divisi_pic'),
            'jabatan_pic'   => (string)$this->request->getPost('jabatan_pic'),
            'kontak_pic'    => (string)$this->request->getPost('kontak_pic')
        ];

        $picModel = new PicModel;
        $picModel->save($insertData);

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

        $find = (new PicModel)->find( $id );
        if($find) {

            (new PicModel)->delete($id);

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