<?php

namespace App\Controllers\Api;

use App\Models\PenawaranModel;
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

        $find = (new PenawaranModel)
            ->builder()
            ->join('permintaan', 'penawaran.id_permintaan=permintaan.id_permintaan', 'left')
            ->join('customers', 'permintaan.id_customer=customers.id_customer')
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
        


        
        $penawaranModel = new PenawaranModel();
        $penawaranModel->builder()
        ->select("

            permintaan.id_permintaan, permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_sales, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey, permintaan.date_create,
            permintaan.keterangan_pekerjaan, permintaan.permintaan_supervisi, permintaan.permintaan_supervisi_status,
            permintaan.permintaan_hasil_survey_status,

            sales.id_user, sales.user_fullname, sales.user_name, sales.user_status,

            survey.id_survey, 
            customers.id_customer, customers.nama_customer, customers.pic_nama_customer, customers.pic_no_customer,

            supervisi.user_fullname as nama_supervisi,

        ")
        ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left')
        ->join('users as supervisi', 'permintaan.permintaan_supervisi=supervisi.id_user', 'left')
        ->join('customers', 'permintaan.id_customer=customers.id_customer', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $penawaranModel->like('penawaran.penawaran_no', $filter['value']);
                            //->orLike('permintaan.permintaan_lokasi_survey', $filter['value'])
                            //->orLike('permintaan.permintaan_jadwal_survey', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($penawaranModel->filterby))) {
                        $penawaranModel->where($filter['key'], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $penawaranModel->orderBy($order['orderby'], $order['order']);
            }
        }


        


        $lists = $penawaranModel->paginate(10, 'group1');
        $pager = $penawaranModel->pager;

        $data = [];
        foreach($lists as $list) 
        {

            $harga = (new PermintaanItemsModel)
                ->builder()
                ->select("SUM(item_qty * item_hp) as estimasi_harga_pokok, SUM(item_qty * item_hj) as estimasi_harga_jual")
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
                'estimasi_harga_jual'   => (int)$harga->estimasi_harga_jual
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
            'id_permintaan' => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
           'id_permintaan'              => $this->request->getPost('id_permintaan'),
           'penawaran_no'               => $this->request->getPost('penawaran_no'),
           'penawaran_due_date'         => $this->request->getPost('penawaran_due_date'),
           'penawaran_validasi_date'    => $this->request->getPost('penawaran_validasi_date'),
           'penawaran_term'             => $this->request->getPost('penawaran_term'),
        ];

        $penawaranModel = new PenawaranModel;
        $penawaranModel->save($insertData);

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
            'id_penawaran'            => 'required',
            'id_permintaan'           => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_penawaran'               => $this->request->getPost('id_penawaran'),
            'id_permintaan'              => $this->request->getPost('id_permintaan'),
            'penawaran_no'               => $this->request->getPost('penawaran_no'),
            'penawaran_due_date'         => $this->request->getPost('penawaran_due_date'),
            'penawaran_validasi_date'    => $this->request->getPost('penawaran_validasi_date'),
            'penawaran_term'             => $this->request->getPost('penawaran_term')
         ];
        $penawaranModel = new PenawaranModel;
        $penawaranModel->save($insertData);

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

        $find = (new PenawaranModel)->find( $id );
        if($find) {

            (new PenawaranModel)->delete($id);

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