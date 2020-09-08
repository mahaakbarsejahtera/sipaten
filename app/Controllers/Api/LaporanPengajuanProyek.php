<?php

namespace App\Controllers\Api;

use App\Models\JenisPengajuanModel;
use App\Models\PengajuanProyekModel;
use CodeIgniter\Controller;

class LaporanPengajuanProyek extends Controller
{
    
    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];



        $find = (new PengajuanProyekModel)->builder()
        ->select("


            pengajuan_proyek.id_pengajuan_proyek, pengajuan_proyek.id_pengaju, pengajuan_proyek.id_anggaran,
            pengajuan_proyek.id_jenis_pengajuan, pengajuan_proyek.perihal_pengajuan_proyek, pengajuan_proyek.no_surat_pengajuan_proyek,
            pengajuan_proyek.tanggal_pengajuan_proyek, pengajuan_proyek.due_date_pengajuan_proyek, pengajuan_proyek.status_laporan_pengajuan_proyek,

            anggaran.id_permintaan,

            permintaan.nama_pekerjaan
           
        ")
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
        


        
        $pengajuanModel = new PengajuanProyekModel();
        $pengajuanModel->builder()
        ->select("


            pengajuan_proyek.id_pengajuan_proyek, pengajuan_proyek.id_pengaju, pengajuan_proyek.id_anggaran,
            pengajuan_proyek.id_jenis_pengajuan, pengajuan_proyek.perihal_pengajuan_proyek, pengajuan_proyek.no_surat_pengajuan_proyek,
            pengajuan_proyek.tanggal_pengajuan_proyek, pengajuan_proyek.due_date_pengajuan_proyek, 

            anggaran.id_permintaan,

            permintaan.nama_pekerjaan,
           
        ")
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
    public function update()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [
            'id_pengajuan_proyek'                       => 'required',
            'status_laporan_pengajuan_proyek'            => 'required'
        ];
    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pengajuan_proyek'               => (double)$this->request->getPost('id_pengajuan_proyek'),
            'status_laporan_pengajuan_proyek'   => (string)$this->request->getPost('status_laporan_pengajuan_proyek'),
        ];
        $pengajuanModel = new PengajuanProyekModel;
        $pengajuanModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
        
    }

    public function laporan()
    {


    }

}