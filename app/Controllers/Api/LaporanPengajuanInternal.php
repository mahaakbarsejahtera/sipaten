<?php

namespace App\Controllers\Api;

use App\Models\JenisPengajuanModel;
use App\Models\PengajuanInternalModel;
use CodeIgniter\Controller;

class LaporanPengajuanInternal extends Controller
{
    
    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];



        $find = (new PengajuanInternalModel)->builder()
        ->select("


            pengajuan_internal.id_pengajuan_internal, pengajuan_internal.id_pengaju, 
            pengajuan_internal.id_jenis_pengajuan, pengajuan_internal.perihal_pengajuan_internal, pengajuan_internal.no_surat_pengajuan_internal,
            pengajuan_internal.tanggal_pengajuan_internal, pengajuan_internal.due_date_pengajuan_internal, pengajuan_internal.status_laporan_pengajuan_internal,
            pengajuan_internal.status_pengajuan_internal, pengajuan_internal.status_laporan_pengajuan_internal
        
        ")
        ->join('jenis_pengajuan', 'pengajuan_internal.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan','left')
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
        


        
        $pengajuanModel = new PengajuanInternalModel();
        $pengajuanModel->builder()
        ->select("

            pengajuan_internal.id_pengajuan_internal, pengajuan_internal.id_pengaju, 
            pengajuan_internal.id_jenis_pengajuan, pengajuan_internal.perihal_pengajuan_internal, 
            pengajuan_internal.no_surat_pengajuan_internal,
            pengajuan_internal.tanggal_pengajuan_internal,
            pengajuan_internal.due_date_pengajuan_internal,
            pengajuan_internal.status_pengajuan_internal, 
            pengajuan_internal.status_laporan_pengajuan_internal
           
        ")
        ->join('jenis_pengajuan', 'pengajuan_internal.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan','left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $pengajuanModel->like('pengajuan_internal.perihal_pengajuan_internal', $filter['value'])
                        ->orLike('pengajuan_internal.no_surat_pengajuan_internal', $filter['value']);

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

        $data = [];

        foreach($lists as $list)
        {

            $data[] = $list + [
                'nilai_pengajuan'       => (new \App\Models\PengajuanInternalItemModel)->builder()
                                        ->select('SUM(pengajuan_internal_price * pengajuan_internal_qty) as total')
                                        ->where('id_pengajuan_internal', $list['id_pengajuan_internal'])
                                        ->get()
                                        ->getRow()->total,
                'pengaju'               => (new \App\Models\UsersModel())->find($list['id_pengaju']),
            ];

        }

        $response['data']['lists']      = $data;
        $response['data']['pagination'] = $pager->links('group1', 'bootstrap_pagination');

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
            'id_pengajuan_internal'                       => 'required',
            'status_laporan_pengajuan_internal'            => 'required'
        ];
    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pengajuan_internal'               => (double)$this->request->getPost('id_pengajuan_internal'),
            'status_laporan_pengajuan_internal'   => (string)$this->request->getPost('status_laporan_pengajuan_internal'),
        ];

        $pengajuanModel = new PengajuanInternalModel;
        $pengajuanModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
        
    }


}