<?php

namespace App\Controllers\Api;

use App\Models\AnggaranModel;
use CodeIgniter\Controller;

class Anggaran extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new AnggaranModel)->find( $id );

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
        


        
        $anggaranModel = new AnggaranModel();

        $anggaranModel->builder()
        ->select("


            anggaran.id_anggaran, anggaran.id_permintaan, anggaran.approval_teknik, anggaran.approval_pemasaran, anggaran.approval_keuangan,

            permintaan.no_permintaan, permintaan.nama_pekerjaan, permintaan.no_survey, permintaan.no_kontrak,
            permintaan.permintaan_status, permintaan.permintaan_user, permintaan.permintaan_lokasi_survey,
            permintaan.permintaan_jadwal_survey, permintaan.date_create, permintaan.permintaan_approval,
            permintaan.approve_by
        
        
        ")
        ->join('permintaan', 'anggaran.id_permintaan=permintaan.id_permintaan', 'left');
        

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $anggaranModel->like('permintaan.nama_pekerjaan', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($anggaranModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $anggaranModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $anggaranModel->paginate(10, 'group1');
        $pager = $anggaranModel->pager;

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
            'id_permintaan'          => 'required',
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
            'id_permintaan'        => $this->request->getPost('id_permintaan'),
            'approval_teknik'      => $this->request->getPost('approval_teknik'),
            'approval_pemasaran'   => $this->request->getPost('approval_pemasaran'),
            'approval_keuangan'    => $this->request->getPost('approval_keuangan')
        ];

        $anggaranModel = db_connect();
        $anggaranModel
            ->table('anggaran')
            ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_anggaran' => $anggaranModel->insertID() ] + $insertData;
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
            'id_anggaran'         => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_anggaran'           => $this->request->getPost('id_anggaran'),
            'id_permintaan'         => $this->request->getPost('id_permintaan'),
            'approval_teknik'       => $this->request->getPost('approval_teknik'),
            'approval_pemasaran'    => $this->request->getPost('approval_pemasaran'),
            'approval_keuangan'     => $this->request->getPost('approval_keuangan')
        ];

        $anggaranModel = new AnggaranModel;
        $anggaranModel->save($insertData);

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

        $find = (new AnggaranModel)->find( $id );
        if($find) {

            (new AnggaranModel)->delete($id);

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