<?php

namespace App\Controllers\Api;

use App\Models\JenisPengajuanModel;
use App\Models\PengajuanProyekModel;
use App\Models\LapPpModel;
use CodeIgniter\Controller;

class LapPp extends Controller
{
    
    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];



        $find = (new LapPpModel)->builder()
        ->select("

            lap_pp.id_lpp,  lap_pp.status_lpp, lap_pp.id_pp, lap_pp.acc_date,

            pengajuan_proyek.id_pengajuan_proyek, pengajuan_proyek.id_pengaju, pengajuan_proyek.id_anggaran,
            pengajuan_proyek.id_jenis_pengajuan, pengajuan_proyek.perihal_pengajuan_proyek, pengajuan_proyek.no_surat_pengajuan_proyek,
            pengajuan_proyek.tanggal_pengajuan_proyek, pengajuan_proyek.due_date_pengajuan_proyek, 

            anggaran.id_permintaan,

            permintaan.nama_pekerjaan
           
        ")
        ->join('pengajuan_proyek', 'lap_pp.id_pp = pengajuan_proyek.id_pengajuan_proyek')
        ->join('anggaran', 'pengajuan_proyek.id_anggaran=anggaran.id_anggaran', 'left')
        ->join('permintaan', 'anggaran.id_permintaan = permintaan.id_permintaan', 'left')
        ->join('jenis_pengajuan', 'pengajuan_proyek.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan','left')
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
        


        
        $pengajuanModel = new LapPpModel();
        $pengajuanModel->builder()
        ->select("

            lap_pp.id_lpp,  lap_pp.status_lpp, lap_pp.id_pp, lap_pp.acc_date,

            pengajuan_proyek.id_pengajuan_proyek, pengajuan_proyek.id_pengaju, pengajuan_proyek.id_anggaran,
            pengajuan_proyek.id_jenis_pengajuan, pengajuan_proyek.perihal_pengajuan_proyek, pengajuan_proyek.no_surat_pengajuan_proyek,
            pengajuan_proyek.tanggal_pengajuan_proyek, pengajuan_proyek.due_date_pengajuan_proyek, 

            anggaran.id_permintaan,

            permintaan.nama_pekerjaan
           
        ")
        ->join('pengajuan_proyek', 'lap_pp.id_pp = pengajuan_proyek.id_pengajuan_proyek')
        ->join('anggaran', 'pengajuan_proyek.id_anggaran=anggaran.id_anggaran', 'left')
        ->join('permintaan', 'anggaran.id_permintaan = permintaan.id_permintaan', 'left')
        ->join('jenis_pengajuan', 'pengajuan_proyek.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan','left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $pengajuanModel->like('pengajuan_proyek.perihal_pengajuan_proyek', $filter['value'])
                        ->orLike('pengajuan_proyek.no_surat_pengajuan_proyek', $filter['value']);

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
                'nilai_pengajuan'       => (new \App\Models\PengajuanProyekItemModel)->builder()
                                        ->select('SUM(pengajuan_proyek_price * pengajuan_proyek_qty) as total')
                                        ->where('id_pengajuan_proyek', $list['id_pengajuan_proyek'])
                                        ->get()
                ->getRow()->total,
                'total_anggaran'        => (new \App\Models\AnggaranItemModel())->builder()
                                        ->select('SUM(anggaran_price * anggaran_qty) as total')
                                        ->where('id_anggaran', $list['id_anggaran'])
                                        ->get()
                                        ->getRow()->total,

                'pengaju'               => (new \App\Models\UsersModel())->find($list['id_pengaju']),
                'total_nilai_pengajuan' => (new \App\Models\PengajuanProyekItemModel)->builder()
                                            ->select('SUM(pengajuan_proyek_price * pengajuan_proyek_qty) as total')
                                            ->join('pengajuan_proyek', 'pengajuan_proyek_item.id_pengajuan_proyek = pengajuan_proyek.id_pengajuan_proyek', 'left')
                                            ->where('id_anggaran', $list['id_anggaran'])
                                            ->get()
                                            ->getRow()->total
                //'penanggung_jawab'  => (new \App\Models\PenanggungJawabModel())->where('id_jenis_pengajuan', $list['id_jenis_pengajuan'])->findAll()
            ];

        }

        $response['data']['lists']      = $data;
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
            'id_pp'           => 'required',
            'status_lpp'           => 'required',

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
            'id_pp'         => (int)$this->request->getPost('id_pp'),
            'status_lpp'    => (int)$this->request->getPost('status_lpp'),
        ];

        
        //return $this->response->setJson($insertData);

        $db = db_connect();
        $pengajuanModel = $db->table('lap_pp')->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_lpp' => $db->insertID() ] + $insertData;
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
            'id_lpp'        => 'required',
            'id_pp'         => 'required',
            'status_lpp'    => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_lpp'        => (double)$this->request->getPost('id_lpp'),
            'id_pp'         => (double)$this->request->getPost('id_pp'),
            'status_lpp'    => (double)$this->request->getPost('status_lpp'),
        ];
        $pengajuanModel = new LapPpModel;
        $pengajuanModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
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

        $find = (new LapPpModel)->find( $id );
        
        if($find) {

            (new LapPpModel)->delete($id);

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