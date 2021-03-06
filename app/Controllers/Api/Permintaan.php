<?php

namespace App\Controllers\Api;

use App\Models\PermintaanModel;
use App\Models\PermintaanItemsModel;
use CodeIgniter\Controller;

class Permintaan extends Controller
{

    public function __construct() {
        
    }

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new PermintaanModel)
        ->builder()
        ->select("

            permintaan.id_permintaan, permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_sales, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey, permintaan.date_create,
            permintaan.keterangan_pekerjaan, permintaan.permintaan_supervisi, permintaan.permintaan_supervisi_status,
            permintaan.permintaan_hasil_survey_status, permintaan.permintaan_nego, permintaan.permintaan_kontrak,

            sales.id_user, sales.user_fullname, sales.user_name, sales.user_status, sales.user_code as sales_code,

            survey.id_survey, 
            customers.id_customer, customers.nama_customer, customers.pic_nama_customer, customers.pic_no_customer, customers.kode_customer,
            pic.id_pic, pic.nama_pic, pic.divisi_pic, pic.kontak_pic, pic.jabatan_pic, 

            supervisi.user_fullname as nama_supervisi, supervisi.user_code as supervisi_code,

            anggaran.id_anggaran

        ")
        ->join('negosiasi', 'permintaan.id_permintaan=negosiasi.id_permintaan', 'left')
        ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left')
        ->join('users as supervisi', 'permintaan.permintaan_supervisi=supervisi.id_user', 'left')
        ->join('customers', 'permintaan.id_customer=customers.id_customer', 'left')
        ->join('pic', 'permintaan.id_pic=pic.id_pic', 'left')
        ->join('anggaran', 'permintaan.id_permintaan=anggaran.id_permintaan', 'left')
        ->find( $id );

        

        if($find) {

            $harga = (new PermintaanItemsModel)
                ->builder()
                ->select("SUM(item_qty * item_hp) as estimasi_harga_pokok, SUM(item_qty * item_hj) as estimasi_harga_jual")
                ->where('id_permintaan', $id)
                ->groupBy('id_permintaan')
                ->get()
                ->getRow();

            $find = $find + [
                'item_hp'               => (int)$find['item_hp'],
                'item_hj'               => (int)$find['item_hp'],
                'item_hp_nego'          => (int)$find['item_hp_nego'],
                'item_hj_nego'          => (int)$find['item_hj_nego'],
                'estimasi_harga_pokok'  => (int)$harga->estimasi_harga_pokok,
                'estimasi_harga_jual'   => (int)$harga->estimasi_harga_jual,
            ];

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
        


        
        $permintaanModel = new PermintaanModel();
        $permintaanModel->builder()
        ->select("

            permintaan.id_permintaan, permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_sales, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey, permintaan.date_create,
            permintaan.keterangan_pekerjaan, permintaan.permintaan_supervisi, permintaan.permintaan_supervisi_status,
            permintaan.permintaan_hasil_survey_status, permintaan.id_pic, permintaan.permintaan_nego, permintaan.permintaan_kontrak,

            sales.id_user, sales.user_fullname, sales.user_name, sales.user_status,

            survey.id_survey, 
            customers.id_customer, customers.nama_customer, customers.pic_nama_customer, customers.pic_no_customer,
            pic.nama_pic, pic.divisi_pic, pic.kontak_pic, pic.jabatan_pic, 

            supervisi.user_fullname as nama_supervisi,

            anggaran.id_anggaran,

            negosiasi.id_nego, 



        ")
        ->join('negosiasi', 'permintaan.id_permintaan=negosiasi.id_permintaan', 'left')
        ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left')
        ->join('users as supervisi', 'permintaan.permintaan_supervisi=supervisi.id_user', 'left')
        ->join('customers', 'permintaan.id_customer=customers.id_customer', 'left')
        ->join('pic', 'permintaan.id_pic=pic.id_pic', 'left')
        //->join('anggaran', 'permintaan.id_permintaan=anggaran.id_permintaan', 'left');
        ->join('anggaran', 'permintaan.id_permintaan=anggaran.id_permintaan', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $permintaanModel->like('permintaan.nama_pekerjaan', $filter['value'])
                            ->orLike('permintaan.permintaan_lokasi_survey', $filter['value'])
                            ->orLike('permintaan.permintaan_jadwal_survey', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($permintaanModel->filterby))) {
                        $permintaanModel->where($filter['key'], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $permintaanModel->orderBy($order['orderby'], $order['order']);
            }
        }


        


        $lists = $permintaanModel->paginate(10, 'group1');
        $pager = $permintaanModel->pager;

        $data = [];
        foreach($lists as $list) 
        {

            $harga = (new PermintaanItemsModel)
                ->builder()
                ->select("
                    SUM(item_qty * item_hp) as estimasi_harga_pokok, 
                    SUM(item_qty * item_hj) as estimasi_harga_jual,
                    SUM(item_qty * item_hj_nego) as estimasi_harga_nego
                ")
                ->where('id_permintaan', $list['id_permintaan'])
                ->groupBy('id_permintaan')
                ->get()
                ->getRow();

   

            $data[] = $list + [
                'item_hp'               => (double)$list['item_hp'],
                'item_hj'               => (double)$list['item_hp'],
                'item_hp_nego'          => (double)$list['item_hp_nego'],
                'item_hj_nego'          => (double)$list['item_hj_nego'],
                'estimasi_harga_pokok'  => (double)$harga->estimasi_harga_pokok,
                'estimasi_harga_jual'   => (double)$harga->estimasi_harga_jual,
                'estimasi_harga_nego'   => (double)$harga->estimasi_harga_nego,
                'files'                 => (new \App\Models\PermintaanFileModel())
                                            ->builder()
                                            ->where('id_permintaan', $list['id_permintaan'])
                                            ->findAll(),
                'total_anggaran'              => (new \App\Models\AnggaranItemModel())
                                            ->builder()
                                            ->select("SUM(anggaran_qty * anggaran_price) as total_anggaran")
                                            ->where('id_anggaran', $list['id_anggaran'])
                                            ->get()
                                            ->getRow()->total_anggaran,
                'total_nilai_pengajuan' => (new \App\Models\PengajuanProyekItemModel)->builder()
                                            ->select('SUM(pengajuan_proyek_price * pengajuan_proyek_qty) as total')
                                            ->join('pengajuan_proyek', 'pengajuan_proyek_item.id_pengajuan_proyek = pengajuan_proyek.id_pengajuan_proyek', 'left')
                                            ->where('id_anggaran', $list['id_anggaran'])
                                            ->get()
                                            ->getRow()->total,

                                            
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


        $rules = [
            'id_customer' => 'required',
            'nama_pekerjaan' => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pic'                     => (int)$this->request->getPost('id_pic'),
            'id_customer'                => (int)$this->request->getPost('id_customer'),
            'nama_pekerjaan'             => (string)$this->request->getPost('nama_pekerjaan'),
            'no_permintaan'              => (string)$this->request->getPost('no_permintaan'),
            'no_survey'                  => (string)$this->request->getPost('no_survey'),
            'no_kontrak'                 => (string)$this->request->getPost('no_kontrak'),
            'permintaan_status'          => (string)$this->request->getPost('permintaan_status'),
            'permintaan_sales'           => (int)$this->request->getPost('permintaan_sales'),
            'permintaan_lokasi_survey'   => (string)$this->request->getPost('permintaan_lokasi_survey'),
            'permintaan_jadwal_survey'   => (string)$this->request->getPost('permintaan_jadwal_survey'),
            'date_create'                => date('Y-m-d'),
            'permintaan_approval'        => $this->request->getPost('permintaan_approval'),
            'approve_by'                 => $this->request->getPost('approve_by'),
            'keterangan_pekerjaan'       => (string)$this->request->getPost('keterangan_pekerjaan'),
            'permintaan_nego'            => (string)$this->request->getPost('permintaan_nego'),
            'permintaan_kontrak'         => (string)$this->request->getPost('permintaan_kontrak'),
        ];

        $permintaanModel = new PermintaanModel;
        $permintaanModel->save($insertData);

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
            'id_permintaan'            => 'required',
            'id_customer'               => 'required',
            'nama_pekerjaan'            => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pic'                    => (int)$this->request->getPost('id_pic'),
            'id_customer'               => (int)$this->request->getPost('id_customer'),
            'id_permintaan'             => (int)$this->request->getPost('id_permintaan'),
            'nama_pekerjaan'            => (string)$this->request->getPost('nama_pekerjaan'),
            'no_permintaan'             => (string)$this->request->getPost('no_permintaan'),
            'no_survey'                 => (string)$this->request->getPost('no_survey'),
            'no_kontrak'                => (string)$this->request->getPost('no_kontrak'),
            'permintaan_status'         => (string)$this->request->getPost('permintaan_status'),
            'permintaan_sales'           => (int)$this->request->getPost('permintaan_sales'),
            'permintaan_lokasi_survey'  => (string)$this->request->getPost('permintaan_lokasi_survey'),
            'permintaan_jadwal_survey'  => (string)$this->request->getPost('permintaan_jadwal_survey'),
            'date_create'               => date('Y-m-d'),
            'permintaan_approval'       => $this->request->getPost('permintaan_approval'),
            'approve_by'                => $this->request->getPost('approve_by'),
            'keterangan_pekerjaan'      => (string)$this->request->getPost('keterangan_pekerjaan'),
            'permintaan_nego'            => (string)$this->request->getPost('permintaan_nego'),
            'permintaan_kontrak'         => (string)$this->request->getPost('permintaan_kontrak'),
        ];

        $permintaanModel = new PermintaanModel;
        $permintaanModel->save($insertData);

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

        $find = (new PermintaanModel)->find( $id );
        if($find) {

            (new PermintaanModel)->delete($id);

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

    public function accPenunjukan($id_permintaan) {

        $response = [
            'code'      => 0,
            'message'   => '',
            'data'      => [],
            'errors'    => []
        ];

        $dataToInsert = [
            'id_permintaan' => $id_permintaan,
            'permintaan_supervisi_status' => $this->request->getPost('permintaan_supervisi_status'),
            'permintaan_supervisi' => $this->request->getPost('permintaan_supervisi')
        ];

        (new PermintaanModel)->save($dataToInsert);

        $response['code']       = 200;
        $response['message']    = 'Success';
        $response['data']       = $dataToInsert;


        return $response;

    }

    public function accHasilSurvey($id_permintaan) {

        $response = [
            'code'      => 0,
            'message'   => '',
            'data'      => [],
            'errors'    => []
        ];

        $dataToInsert = [
            'id_permintaan'                     => $id_permintaan,
            'permintaan_supervisi'              => $this->request->getPost('permintaan_supervisi'),
            'permintaan_hasil_survey_status'    => $this->request->getPost('permintaan_hasil_survey_status')
        ];

        (new PermintaanModel)->save($dataToInsert);

        $response['code']       = 200;
        $response['message']    = 'Success';
        $response['data']       = $dataToInsert;


        return $response;

    }

  

}