<?php

namespace App\Controllers\Api;

use App\Models\JenisPengajuanModel;
use App\Models\PengajuanInternalModel;
use CodeIgniter\Controller;

class PengajuanInternal extends Controller
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
            pengajuan_internal.tanggal_pengajuan_internal, pengajuan_internal.due_date_pengajuan_internal, 
           
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
            pengajuan_internal.id_jenis_pengajuan, pengajuan_internal.perihal_pengajuan_internal, pengajuan_internal.no_surat_pengajuan_internal,
            pengajuan_internal.tanggal_pengajuan_internal, pengajuan_internal.due_date_pengajuan_internal, 
           
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
                //'penanggung_jawab'  => (new \App\Models\PenanggungJawabModel())->where('id_jenis_pengajuan', $list['id_jenis_pengajuan'])->findAll()
            ];

        }

        $response['data']['lists'] = $data;
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
            'id_pengaju'                      => (int)$this->request->getPost('id_pengaju'),
            'id_jenis_pengajuan'              => (int)$this->request->getPost('id_jenis_pengajuan'),
            'perihal_pengajuan_internal'      => (string)$this->request->getPost('perihal_pengajuan_internal'),
            'no_surat_pengajuan_internal'     => (string)$this->generateNomorSurat($this->request->getPost('id_jenis_pengajuan')),
            'tanggal_pengajuan_internal'      => (string)$this->request->getPost('tanggal_pengajuan_internal'),
            'due_date_pengajuan_internal'     => (string)$this->request->getPost('due_date_pengajuan_internal')
        ];

        // $db = db_connect()->table('pengajuan_internal');
        // $insertData['sql'] = $db
        //     ->set($insertData)
        //     ->getCompiledInsert();

        // return $this->response->setJson($insertData);

        $db = db_connect();
        $pengajuanModel = $db
                            ->table('pengajuan_internal')
                            ->insert($insertData);
        

        $response['code']       = 200;
        $response['data']       = [ 'id_pengajuan_internal' => $db->insertID() ] + $insertData;
        $response['message']    = 'Insert Success';
        //$response['compiled']   = $pengajuanModel->getCompiledInsert();

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
            'id_pengajuan_internal'   => 'required',
            'id_pengaju'            => 'required',
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
            'id_pengajuan_internal'           => (double)$this->request->getPost('id_pengajuan_internal'),
            'id_pengaju'                    => (double)$this->request->getPost('id_pengaju'),
            'id_jenis_pengajuan'            => (double)$this->request->getPost('id_jenis_pengajuan'),
            'perihal_pengajuan_internal'      => (string)$this->request->getPost('perihal_pengajuan_internal'),
            'no_surat_pengajuan_internal'     => (string)($this->request->getPost('id_jenis_pengajuan')),
            'tanggal_pengajuan_internal'      => (string)$this->request->getPost('tanggal_pengajuan_internal'),
            'due_date_pengajuan_internal'     => (string)$this->request->getPost('due_date_pengajuan_internal')
        ];
        $pengajuanModel = new PengajuanInternalModel;
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

        $find = (new PengajuanInternalModel)->find( $id );
        
        if($find) {

            (new PengajuanInternalModel)->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        return $this->response->setJson($response);
    }


    private function generateNomorSurat( $jenis_pengajuan ) {
        
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
        $query = (new PengajuanInternalModel())->builder()->select("max(tanggal_pengajuan_internal) as maxKode")
            ->where('id_jenis_pengajuan',  $jenis_pengajuan)
            ->where('month(tanggal)', $bulan)
            ->get();
        $data  = $query->getRow();
        $no= $data['maxKode'];
        $noUrut= $no + 1;
        
        //membuat Nomor Surat Otomatis dengan awalan depan 0 misalnya , 01,02 
        //jika ingin 003 ,tinggal ganti %03
        $kode =  sprintf("%03s", $noUrut);
        $nomorbaru = $kode.$nomor;

        return $nomorbaru;
    }

}