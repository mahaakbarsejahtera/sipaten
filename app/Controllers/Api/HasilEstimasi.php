<?php

namespace App\Controllers\Api;

use App\Models\HasilEstimasiModel;
use CodeIgniter\Controller;

class HasilEstimasi extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new HasilEstimasiModel)->find( $id );

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
        


        
        $hasilEstimasiModel = new HasilEstimasiModel();
        $hasilModel -> builder()
        ->select("
        hasil_estimasi.id_estimasi_item, hasil_estimasi.id_estimasi, hasil_estimasi.estimasi_item_name, 
        hasil_estimasi.estimasi_item_qty, hasil_estimasi.estimasi_item_unit, hasil_estimasi.estimasi_harga_pokok,
        hasil_estimasi.estimasi_harga_jual, hasil_estimasi.estimasi_harga_pokok_nego, 
        hasil_estimasi.estimasi_harga_jual_nego,
        estimasi.id_permintaan, estimasi.estimasi_approve_status, estimasi.estimasi_approve_by
    ")
    ->join('estimasi', 'hasil_estimasi.id_estimasi=estimasi.id_estimasi', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $hasilEstimasiModel->like('hasil_estimasi.estimasi_item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($hasilEstimasiModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $hasilEstimasiModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $hasilEstimasiModel->paginate(10, 'group1');
        $pager = $hasilEstimasiModel->pager;

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
            'id_estimasi'                => 'required',
            'estimasi_item_name'         => 'required',
            'estimasi_item_qty'          => 'required',
            'estimasi_item_unit'         => 'required',
            'estimasi_harga_pokok'       => 'required',
            'estimasi_harga_pokok_nego'  => 'required',
            'estimasi_harga_jual_nego'   => 'required'
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
            'id_estimasi'                => $this->request->getPost('id_estimasi'),
            'estimasi_item_name'         => $this->request->getPost('estimasi_item_name'),
            'estimasi_item_qty'          => $this->request->getPost('estimasi_item_qty'),
            'estimasi_item_unit'         => $this->request->getPost('estimasi_item_unit'),
            'estimasi_harga_pokok'       => $this->request->getPost('estimasi_harga_pokok'),
            'estimasi_harga_pokok_nego'  => $this->request->getPost('estimasi_harga_pokok_nego'),
            'estimasi_harga_jual_nego'   => $this->request->getPost('estimasi_harga_jual_nego'),

        ];


        $hasilEstimasiModel = new HasilEstimasiModel;
        $hasilEstimasiModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $hasilEstimasiModel->getInsertID();
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
            'id_estimasi_item'           => 'required',
            'id_estimasi'                => 'required',
            'estimasi_item_name'         => 'required',
            'estimasi_item_qty'          => 'required',
            'estimasi_item_unit'         => 'required',
            'estimasi_harga_pokok'       => 'required',
            'estimasi_harga_pokok_nego'  => 'required',
            'estimasi_harga_jual_nego'   => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_estimasi_item'           => $this->request->getPost('id_estimasi_item'),
            'id_estimasi'                => $this->request->getPost('id_estimasi'),
            'estimasi_item_name'         => $this->request->getPost('estimasi_item_name'),
            'estimasi_item_qty'          => $this->request->getPost('estimasi_item_qty'),
            'estimasi_item_unit'         => $this->request->getPost('estimasi_item_unit'),
            'estimasi_harga_pokok'       => $this->request->getPost('estimasi_harga_pokok'),
            'estimasi_harga_pokok_nego'  => $this->request->getPost('estimasi_harga_pokok_nego'),
            'estimasi_harga_jual_nego'   => $this->request->getPost('estimasi_harga_jual_nego'),
        ];

        $hasilEstimasiModel = new HasilEstimasiModel;
        $hasilEstimasiModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $this->request->getPost('id_role');
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

        $find = (new HasilEstimasiModel)->find( $id );
        if($find) {

            (new HasilEstimasiModel)->delete($id);

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