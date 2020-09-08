<?php

namespace App\Controllers\Api;

use App\Models\PenawaranModel;
use App\Models\PermintaanItemsModel;
use App\Models\PermintaanModel;
use CodeIgniter\Controller;

class Penawaran extends Controller
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

            penawaran.id_penawaran, penawaran.penawaran_no, penawaran.penawaran_validasi_date, penawaran.penawaran_due_date, penawaran.penawaran_term, 

            permintaan.id_permintaan, permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_sales, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey, permintaan.date_create,
            permintaan.keterangan_pekerjaan, permintaan.permintaan_supervisi, permintaan.permintaan_supervisi_status,
            permintaan.permintaan_hasil_survey_status,

            sales.id_user, sales.user_fullname, sales.user_name, sales.user_status,

            survey.id_survey, 
            customers.id_customer, customers.nama_customer, customers.pic_nama_customer, customers.pic_no_customer,

            supervisi.user_fullname as nama_supervisi

        ")
        ->join('permintaan', 'penawaran.id_permintaan=permintaan.id_permintaan', 'left')
        ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left')
        ->join('users as supervisi', 'permintaan.permintaan_supervisi=supervisi.id_user', 'left')
        ->join('customers', 'permintaan.id_customer=customers.id_customer', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $penawaranModel->like('penawaran.penawaran_no', $filter['value'])
                        ->orLike('permintaan.nama_pekerjaan', $filter['value'])
                    ->orLike('penawaran.penawaran_no', $filter['value']);

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
           'id_permintaan'              => (int)$this->request->getPost('id_permintaan'),
           'penawaran_no'               => (string)$this->noPenawaran($this->request->getPost('id_permintaan')),
           'penawaran_due_date'         => (string)$this->request->getPost('penawaran_due_date'),
           'penawaran_validasi_date'    => (string)$this->request->getPost('penawaran_validasi_date'),
           'penawaran_term'             => (string)$this->request->getPost('penawaran_term'),
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
            'id_penawaran'               => (int)$this->request->getPost('id_penawaran'),
            'id_permintaan'              => (int)$this->request->getPost('id_permintaan'),
            'penawaran_no'               => (string)$this->noPenawaran($this->request->getPost('id_permintaan')),
            'penawaran_due_date'         => (string)$this->request->getPost('penawaran_due_date'),
            'penawaran_validasi_date'    => (string)$this->request->getPost('penawaran_validasi_date'),
            'penawaran_term'             => (string)$this->request->getPost('penawaran_term')
         ];

         
        $find = (new PenawaranModel())->find((int)$this->request->getPost('id_penawaran'));
        
        if($find->id_permintaan == $this->request->getPost('id_permintaan')) unset($insertData['penawaran_no']);
        
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

    public function noPenawaran( $id_permintaan ) {

        $months = [
            'I', 'II', 'III',
            'IV', 'V', 'VI',
            'VII', 'VIII', 'IX',
            'X', 'XI', 'XII'
        ];

        $bulan = date('n');

        $permintaan = (new PermintaanModel)
            ->builder()
            ->select("
            

                customers.kode_customer, 
                sales.user_code
            
            
            ")
            ->join('customers', 'permintaan.id_customer=customers.id_customer')
            ->join('users as sales', 'permintaan.permintaan_sales = sales.id_user')
            ->where('permintaan.id_permintaan', $id_permintaan)
            ->get()->getRow();

   

        $user_code      = $permintaan->user_code;
        $customer_code  = $permintaan->kode_customer;
        
        $nomor          = "/PN/{$user_code}/{$customer_code}/" . $months[(int)date('m')-1] ."/" . date('Y');
        $query          = (new PenawaranModel())->builder()->select("max(penawaran.penawaran_no) as maxKode")
                            ->where('MONTH(penawaran_due_date)', $bulan)
                            ->get();

        $data           = $query->getRow();
        $no             = $data->maxKode;
        $noUrut         = $no + 1;
        $kode           = sprintf("%03s", $noUrut);
        $nomorbaru      = $kode . $nomor;

        return $nomorbaru;

    }

  
}