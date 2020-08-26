<?php

namespace App\Controllers\Api;

use App\Models\AnggaranItemModel;
use CodeIgniter\Controller;

class AnggaranItem extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new AnggaranItemModel)->find( $id );

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
        


        
        $pengajuanItemModel = new AnggaranItemModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                       
                        $pengajuanItemModel->like('anggaran_item.anggaran_item', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($pengajuanItemModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $pengajuanItemModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $pengajuanItemModel->paginate(10, 'group1');
        $pager = $pengajuanItemModel->pager;

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

        // Dinamis ikuti table
        $rules = [
            'id_anggaran'      => 'required',

        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }


        // Dinamis ikuti table
        $insertData = [
            'id_anggaran'          => (int)$this->request->getPost('id_anggaran'),   
            'jenis_anggaran'       => (string)$this->request->getPost('jenis_anggaran'),
            'anggaran_item'        => (string)$this->request->getPost('anggaran_item'),
            'anggaran_qty'         => (double)$this->request->getPost('anggaran_qty'),
            'anggaran_unit'        => (string)$this->request->getPost('anggaran_unit'),
            'anggaran_price'       => (double)$this->request->getPost('anggaran_price')     
        ];


        $anggaranItemModel = db_connect();
        $anggaranItemModel
            ->table('anggaran_item')
            ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_anggaran_item' => $anggaranItemModel->insertID() ] + $insertData;
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
            'id_anggaran_item'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_anggaran_item'     => $this->request->getPost('id_anggaran_item'),
            'id_anggaran'          => $this->request->getPost('id_anggaran'),
            'jenis_anggaran'       => $this->request->getPost('jenis_anggaran'),
            'anggaran_item'        => $this->request->getPost('anggaran_item'),
            'anggaran_qty'         => $this->request->getPost('anggaran_qty'),
            'anggaran_unit'        => $this->request->getPost('anggaran_unit'),
            'anggaran_price'       => $this->request->getPost('anggaran_price'),
        ];

        $anggaranItemModel = new AnggaranItemModel;
        $anggaranItemModel->save($insertData);

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

        $find = (new AnggaranItemModel)->find( $id );
        if($find) {

            (new AnggaranItemModel)->delete($id);

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

    }

}