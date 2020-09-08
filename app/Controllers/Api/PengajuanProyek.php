<?php

namespace App\Controllers\Api;

use App\Models\JenisPengajuanModel;
use App\Models\PengajuanProyekModel;
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



        $find = (new PengajuanProyekModel)->builder()
        ->select("


            pengajuan_proyek.id_pengajuan_proyek, pengajuan_proyek.id_pengaju, pengajuan_proyek.id_anggaran,
            pengajuan_proyek.id_jenis_pengajuan, pengajuan_proyek.perihal_pengajuan_proyek, pengajuan_proyek.no_surat_pengajuan_proyek,
            pengajuan_proyek.tanggal_pengajuan_proyek, pengajuan_proyek.due_date_pengajuan_proyek, 

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
            'id_pengaju'           => 'required',
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
            'id_pengaju'                    => (int)$this->request->getPost('id_pengaju'),
            'id_anggaran'                   => (int)$this->request->getPost('id_anggaran'),
            'id_jenis_pengajuan'            => (int)$this->request->getPost('id_jenis_pengajuan'),
            'perihal_pengajuan_proyek'      => (string)$this->request->getPost('perihal_pengajuan_proyek'),
            'no_surat_pengajuan_proyek'     => (string)$this->generateNomorSurat($this->request->getPost('id_jenis_pengajuan')),
            'tanggal_pengajuan_proyek'      => (string)$this->request->getPost('tanggal_pengajuan_proyek'),
            'due_date_pengajuan_proyek'     => (string)$this->request->getPost('due_date_pengajuan_proyek')
        ];

        
        //return $this->response->setJson($insertData);

        $db = db_connect();
        $pengajuanModel = $db
                            ->table('pengajuan_proyek')
                            ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_pengajuan_proyek' => $db->insertID() ] + $insertData;
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
            'id_pengajuan_proyek'   => 'required',
            'id_pengaju'            => 'required',
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
            'id_pengajuan_proyek'           => (double)$this->request->getPost('id_pengajuan_proyek'),
            'id_pengaju'                    => (double)$this->request->getPost('id_pengaju'),
            'id_anggaran'                   => (double)$this->request->getPost('id_anggaran'),
            'id_jenis_pengajuan'            => (double)$this->request->getPost('id_jenis_pengajuan'),
            'perihal_pengajuan_proyek'      => (string)$this->request->getPost('perihal_pengajuan_proyek'),
            //'no_surat_pengajuan_proyek'     => (string)$this->generateNomorSurat($this->request->getPost('id_jenis_pengajuan')),
            'no_surat_pengajuan_proyek'     => (string)($this->request->getPost('id_jenis_pengajuan')),
            'tanggal_pengajuan_proyek'      => (string)$this->request->getPost('tanggal_pengajuan_proyek'),
            'due_date_pengajuan_proyek'     => (string)$this->request->getPost('due_date_pengajuan_proyek')
        ];
        $pengajuanModel = new PengajuanProyekModel;
        $pengajuanModel->save($insertData);

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


    public function generateNomorSurat( $jenis_pengajuan ) 
    {
        
        $bulan = date('n');
        $romawi = '';
        
        switch ($bulan){
            case 1: 
                $romawi = "I";
            break;
            case 2:
                $romawi = "II";
            break;
            case 3:
                $romawi = "III";
            break;
            case 4:
                $romawi = "IV";
            break;
            case 5:
                $romawi = "V";
            break;
            case 6:
                $romawi = "VI";
            break;
            case 7:
                $romawi = "VII";
            break;
            case 8:
                $romawi = "VIII";
            break;
            case 9:
                $romawi = "IX";
            break;
            case 10:
                $romawi = "X";
            break;
            case 11:
                $romawi = "XI";
            break;
            case 12:
                $romawi = "XII";
            break;
        }

        $tahun = date ('Y');

        $kodeJenisPengajuan = (new JenisPengajuanModel())->find($jenis_pengajuan)['kode_jenis_pengajuan'];


        $nomor = "/{$kodeJenisPengajuan}/{$romawi}/{$tahun}";
        
        // membaca kode / nilai tertinggi dari penomoran yang ada didatabase berdasarkan tanggal
        $query = (new PengajuanProyekModel())->builder()->select("max(pengajuan_proyek.no_surat_pengajuan_proyek) as maxKode")
            ->where('pengajuan_proyek.id_jenis_pengajuan', $jenis_pengajuan)
            ->where('MONTH(tanggal_pengajuan_proyek)', $bulan)
            ->get();

        $data  = $query->getRow();

        $no= $data->maxKode;
        
        $noUrut= $no + 1;
        
        //echo $noUrut . '<br>';
        
        //membuat Nomor Surat Otomatis dengan awalan depan 0 misalnya , 01,02 
        //jika ingin 003 ,tinggal ganti %03
        $kode =  sprintf("%03s", $noUrut);
        $nomorbaru = $kode.$nomor;

        return $nomorbaru;
    }


}