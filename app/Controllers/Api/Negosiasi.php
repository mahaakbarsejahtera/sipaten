<?php

namespace App\Controllers\Api;

use App\Models\PermintaanModel;
use App\Models\PermintaanItemsModel;
use App\Models\NegosiasiModel;
use CodeIgniter\Controller;

class Negosiasi extends Controller
{



    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new NegosiasiModel)
        ->builder()
        ->select("

            negosiasi.id_permintaan, negosiasi.id_nego, negosiasi.nego_term, negosiasi.nego_pic_nama, negosiasi.nego_pic_jabatan, 

            
            penawaran.penawaran_no, penawaran.penawaran_due_date, penawaran.penawaran_validasi_date, penawaran.penawaran_term,

            permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_sales, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey, permintaan.date_create,
            permintaan.keterangan_pekerjaan, permintaan.permintaan_supervisi, permintaan.permintaan_supervisi_status,
            permintaan.permintaan_hasil_survey_status,

            sales.id_user, sales.user_fullname, sales.user_name, sales.user_status, sales.user_code as sales_code,

            survey.id_survey, 
            customers.id_customer, customers.nama_customer, customers.pic_nama_customer, customers.pic_no_customer, customers.kode_customer,
            pic.id_pic, pic.nama_pic, pic.divisi_pic, pic.kontak_pic, pic.jabatan_pic, 

            supervisi.user_fullname as nama_supervisi, supervisi.user_code as supervisi_code

        ")
        ->join('permintaan', 'negosiasi.id_permintaan=permintaan.id_permintaan', 'left')
        ->join('penawaran', 'negosiasi.id_permintaan=penawaran.id_permintaan', 'left')
        ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left')
        ->join('users as supervisi', 'permintaan.permintaan_supervisi=supervisi.id_user', 'left')
        ->join('customers', 'permintaan.id_customer=customers.id_customer', 'left')
        ->join('pic', 'permintaan.id_pic=pic.id_pic', 'left')
        ->find( $id );

        

        if($find) {

            $harga = (new PermintaanItemsModel)
                ->builder()
                ->select("
                    SUM(item_qty * item_hp) as estimasi_harga_pokok, 
                    SUM(item_qty * item_hj) as estimasi_harga_jual, 
                    SUM(item_qty * item_hj_nego) as estimasi_harga_nego
                ")
                ->where('id_permintaan', $find['id_permintaan'])
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
                'estimasi_harga_nego'   => (int)$harga->estimasi_harga_nego
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
        


        
        $negosiasiModel = new NegosiasiModel();
        $negosiasiModel->builder()
        ->select("

            permintaan.id_permintaan, permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_sales, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey, permintaan.date_create,
            permintaan.keterangan_pekerjaan, permintaan.permintaan_supervisi, permintaan.permintaan_supervisi_status,
            permintaan.permintaan_hasil_survey_status, permintaan.id_pic,

            sales.id_user, sales.user_fullname, sales.user_name, sales.user_status,

            survey.id_survey, 
            customers.id_customer, customers.nama_customer, customers.pic_nama_customer, customers.pic_no_customer,
            pic.nama_pic, pic.divisi_pic, pic.kontak_pic, pic.jabatan_pic, 

            supervisi.user_fullname as nama_supervisi,

            penawaran.penawaran_no, penawaran.penawaran_due_date, penawaran.penawaran_validasi_date, penawaran.penawaran_term,
            negosiasi.id_nego, negosiasi.nego_term, negosiasi.nego_pic_nama, negosiasi.nego_pic_jabatan

        ")
        ->join('permintaan', 'negosiasi.id_permintaan=permintaan.id_permintaan', 'left')
        ->join('penawaran', 'negosiasi.id_permintaan=penawaran.id_permintaan', 'left')
        ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left')
        ->join('users as supervisi', 'permintaan.permintaan_supervisi=supervisi.id_user', 'left')
        ->join('customers', 'permintaan.id_customer=customers.id_customer', 'left')
        ->join('pic', 'permintaan.id_pic=pic.id_pic', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $negosiasiModel->like('permintaan.nama_pekerjaan', $filter['value'])
                            ->orLike('negosiasi.nego_pic_nama', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($negosiasiModel->filterby))) {
                        $negosiasiModel->where($filter['key'], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $negosiasiModel->orderBy($order['orderby'], $order['order']);
            }
        }


        


        $lists = $negosiasiModel->paginate(10, 'group1');
        $pager = $negosiasiModel->pager;

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
                'item_hp'               => (int)$list['item_hp'],
                'item_hj'               => (int)$list['item_hp'],
                'item_hp_nego'          => (int)$list['item_hp_nego'],
                'item_hj_nego'          => (int)$list['item_hj_nego'],
                'estimasi_harga_pokok'  => (int)$harga->estimasi_harga_pokok,
                'estimasi_harga_jual'   => (int)$harga->estimasi_harga_jual,
                'estimasi_harga_nego'   => (int)$harga->estimasi_harga_nego
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
            'id_permintaan' => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_permintaan'             => $this->request->getPost('id_permintaan'),
            'nego_term'                 => $this->request->getPost('nego_term'),
            'nego_pic_nama'             => $this->request->getPost('nego_pic_nama'),
            'nego_pic_jabatan'          => $this->request->getPost('nego_pic_jabatan'),
        ];

        $permintaanModel = new NegosiasiModel();
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
            'id_nego'            => 'required',
            'id_permintaan'      => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_nego'                   => $this->request->getPost('id_nego'),
            'id_permintaan'             => $this->request->getPost('id_permintaan'),
            'nego_term'                 => $this->request->getPost('nego_term'),
            'nego_pic_nama'             => $this->request->getPost('nego_pic_nama'),
            'nego_pic_jabatan'          => $this->request->getPost('nego_pic_jabatan'),
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

        $find = (new NegosiasiModel)->find( $id );
        if($find) {

            (new NegosiasiModel)->delete($id);

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

    public function updateNegosiasi() {

        $response = [
            'code'      => 0,
            'message'   => '',
            'data'      => [],
            'errors'    => []
        ];

        $dataToInsert = [
            'id_item'           => $this->request->getPost('id_item'),
            'item_hj_nego'      => $this->request->getPost('item_hj_nego'),
        ];

        (new PermintaanItemsModel())->save($dataToInsert);

        $response['code']       = 200;
        $response['message']    = 'Success';
        $response['data']       = $dataToInsert;


        return $response;

    }

  

}