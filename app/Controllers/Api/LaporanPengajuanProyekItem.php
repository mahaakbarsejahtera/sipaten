<?php

namespace App\Controllers\Api;

use App\Models\LaporanPengajuanProyekItemModel;
use CodeIgniter\Controller;

class LaporanPengajuanProyekItem extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new LaporanPengajuanProyekItemModel)->find( $id );

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
        
        $pengajuanItemModel = new LaporanPengajuanProyekItemModel();
        $pengajuanItemModel->builder()
        ->join('anggaran_item', 'pengajuan_proyek_item.id_anggaran_item=anggaran_item.id_anggaran_item', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                       
                        $pengajuanItemModel->like('pengajuan_item.pengajuan_item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($pengajuanItemModel->filterby))) {
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

        if($no_limit) 
        {

            $lists                          = $pengajuanItemModel->findAll();

        } 
        else 
        {

            $lists                          = $pengajuanItemModel->paginate(10, 'group1');
            $pager                          = $pengajuanItemModel->pager;
            $response['data']['pagination'] = $pager->links('group1', 'bootstrap_pagination');

        }   

        foreach($lists as $list)
        {

            $data[] = $list;

        }



        $response['data']['lists'] = $data;
        

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
            'id_pengajuan_proyek_item'      => 'required',
        ];

        $message_rules = [];
    
        if(!$this->validate($rules, $message_rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

      

        $insertData = [
            'id_pengajuan_proyek_item'          => (int)$this->request->getPost('id_pengajuan_proyek_item'),
            'pengajuan_proyek_actual_qty'       => (double)$this->request->getPost('pengajuan_proyek_actual_qty'),
            'pengajuan_proyek_actual_price'     => (double)$this->request->getPost('pengajuan_proyek_actual_price'),
            
        ];

        $pengajuanItemModel = new LaporanPengajuanProyekItemModel;
        $pengajuanItemModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
        
    }


}