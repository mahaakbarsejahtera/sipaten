<?php

namespace App\Controllers\Api;

use App\Models\PengajuanInternalItemModel;
use CodeIgniter\Controller;

class PengajuanInternalItem extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new PengajuanInternalItemModel)->find( $id );

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
        


        
        $pengajuanItemModel = new PengajuanInternalItemModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                       
                        $pengajuanItemModel->like('pengajuan_item.pengajuan_item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($pengajuanItemModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                        $pengajuanItemModel->where($pengajuanItemModel->filterby[$filter['key']], $filter['value']);
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
            'id_pengajuan_internal'   => 'required',

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
            'id_pengajuan_internal'           => $this->request->getPost('id_pengajuan_internal'),
            'pengajuan_internal_name'         => (string)$this->request->getPost('pengajuan_internal_name'),
            'pengajuan_internal_desc'         => (string)$this->request->getPost('pengajuan_internal_desc'),
            'pengajuan_internal_qty'          => (double)$this->request->getPost('pengajuan_internal_qty'),
            'pengajuan_internal_unit'         => (string)$this->request->getPost('pengajuan_internal_unit'),
            'pengajuan_internal_price'        => (double)$this->request->getPost('pengajuan_internal_price'),
            'pengajuan_internal_keterangan'   => (string)$this->request->getPost('pengajuan_internal_keterangan'),
            
        ];

        $db                 = db_connect();
        $pengajuanItemModel = $db
                                ->table('pengajuan_internal_item')
                                ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_pengajuan_internal_item' => $db->insertID() ] +  $insertData;
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
            'id_pengajuan_internal_item'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pengajuan_internal_item'      => (int)$this->request->getPost('id_pengajuan_internal_item'),
            'id_pengajuan_internal'           => (int)$this->request->getPost('id_pengajuan_internal'),
            'pengajuan_internal_name'         => (string)$this->request->getPost('pengajuan_internal_name'),
            'pengajuan_internal_desc'         => (string)$this->request->getPost('pengajuan_internal_desc'),
            'pengajuan_internal_qty'          => (double)$this->request->getPost('pengajuan_internal_qty'),
            'pengajuan_internal_unit'         => (string)$this->request->getPost('pengajuan_internal_unit'),
            'pengajuan_internal_price'        => (double)$this->request->getPost('pengajuan_internal_price'),
            'pengajuan_internal_keterangan'   => (string)$this->request->getPost('pengajuan_internal_keterangan'),
            
        ];

        $pengajuanItemModel = new PengajuanInternalItemModel;
        $pengajuanItemModel->save($insertData);

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

        $find = (new PengajuanInternalItemModel)->find( $id );
        if($find) {

            (new PengajuanInternalItemModel)->delete($id);

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