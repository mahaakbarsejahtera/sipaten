<?php

namespace App\Controllers\Api;

use App\Models\PengajuanProyekModel;
use App\Models\PengajuanInternalModel;
use CodeIgniter\Controller;

class PengajuanProyek extends Controller
{
    
    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];



        $find = (new PengajuanProyekModel)->find( $id );

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
        


        
        $pengajuanModel = new PengajuanProyekModel();
        $pengajuanModel->builder()
        ->select("


            pengajuan.id_pengajuan, pengajuan.id_anggaran, pengajuan.id_jenis_pengajuan, 
            anggaran.id_permintaan, anggaran.approval_teknik, anggaran.approval_pemasaran, anggaran.approval_keuangan,
            jenis_pengajuan.nama_jenis_pengajuan
           
        ")
        ->join('anggaran', 'pengajuan.id_anggaran=anggaran.id_anggaran', 'left')
        ->join('jenis_pengajuan', 'pengajuan.id_jenis_pengajuan=jenis_anggran.id_jenis_anggaran','left');
        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $pengajuanModel->like('jenis_pengajuan.nama_jenis_pengajuan', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($pengajuanModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                        $pengajuanModel->where($pengajuanModel->filterby[$filter['key']], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $pengajuanModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $pengajuanModel->paginate(10, 'group1');
        $pager = $pengajuanModel->pager;

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
            'id_anggaran'           => 'required',
            'id_jenis_pengajuan'    => 'required'

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
            'id_anggaran'            => $this->request->getPost('id_anggaran'),
            'id_jenis_pengajuan'     => $this->request->getPost('id_jenis_pengajuan')
        ];


        $pengajuanModel = new PengajuanProyekModel;
        $pengajuanModel->save($insertData);

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
            'id_pengajuan'          =>'required',
            'id_anggaran'           => 'required',
            'id_jenis_pengajuan'    => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pengajuan_proyek'          => $this->request->getPost('id_pengajuan_proyek'),
            'id_anggaran'            => $this->request->getPost('id_anggaran'),
            'id_jenis_pengajuan'     => $this->request->getPost('id_jenis_pengajuan')
        ];

        $pengajuanModel = new PengajuanProyekModel;
        $pengajuanModel->save($insertData);

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

        $find = (new PengajuanProyekModel)->find( $id );
        if($find) {

            (new PengajuanProyekModel)->delete($id);

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