<?php

namespace App\Controllers\Api;

use App\Models\PengajuanProyekItemModel;
use CodeIgniter\Controller;

class PengajuanProyekItem extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new PengajuanProyekItemModel)->find( $id );

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
        


        
        $pengajuanItemModel = new PengajuanProyekItemModel();

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
            'id_pengajuan_proyek'   => 'required',

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
            'id_pengajuan_proyek'           => $this->request->getPost('id_pengajuan_proyek'),
            'pengajuan_proyek_name'         => (string)$this->request->getPost('pengajuan_proyek_name'),
            'pengajuan_proyek_desc'         => (string)$this->request->getPost('pengajuan_proyek_desc'),
            'pengajuan_proyek_qty'          => (double)$this->request->getPost('pengajuan_proyek_qty'),
            'pengajuan_proyek_unit'         => (string)$this->request->getPost('pengajuan_proyek_unit'),
            'pengajuan_proyek_price'        => (double)$this->request->getPost('pengajuan_proyek_price'),
            'pengajuan_proyek_keterangan'   => (string)$this->request->getPost('pengajuan_proyek_keterangan'),
            
        ];

        $db                 = db_connect();
        $pengajuanItemModel = $db
                                ->table('pengajuan_proyek_item')
                                ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_pengajuan_proyek_item' => $db->insertID() ] +  $insertData;
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
            'id_pengajuan_proyek_item'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pengajuan_proyek_item'      => (int)$this->request->getPost('id_pengajuan_proyek_item'),
            'id_pengajuan_proyek'           => (int)$this->request->getPost('id_pengajuan_proyek'),
            'pengajuan_proyek_name'         => (string)$this->request->getPost('pengajuan_proyek_name'),
            'pengajuan_proyek_desc'         => (string)$this->request->getPost('pengajuan_proyek_desc'),
            'pengajuan_proyek_qty'          => (double)$this->request->getPost('pengajuan_proyek_qty'),
            'pengajuan_proyek_unit'         => (string)$this->request->getPost('pengajuan_proyek_unit'),
            'pengajuan_proyek_price'        => (double)$this->request->getPost('pengajuan_proyek_price'),
            'pengajuan_proyek_keterangan'   => (string)$this->request->getPost('pengajuan_proyek_keterangan'),
            
        ];

        $pengajuanItemModel = new PengajuanProyekItemModel;
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

        $find = (new PengajuanProyekItemModel)->find( $id );
        if($find) {

            (new PengajuanProyekItemModel)->delete($id);

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