<?php

namespace App\Controllers\Api;

use App\Models\CustomersModel;
use CodeIgniter\Controller;

class Customer extends Controller
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

        $find = (new CustomersModel)->find( $id );

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
        


        
        $customersModel = new CustomersModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $customersModel->like('customers.nama_customer', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($customersModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $customersModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $customersModel->paginate(10, 'group1');
        $pager = $customersModel->pager;

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


        $rules = [
            'nama_customer'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'nama_customer'         => (string)$this->request->getPost('nama_customer'),
            'alamat_customer'       => (string)$this->request->getPost('alamat_customer'),
            'pic_nama_customer'     => (string)$this->request->getPost('pic_nama_customer'),
            'pic_no_customer'       => (string)$this->request->getPost('pic_no_customer'),
            'kode_customer'         => (string)$this->request->getPost('kode_customer')
        ];

        $customersModel = new CustomersModel;
        $customersModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $customersModel->getInsertID();
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
            'id_customer'       => 'required',
            'nama_customer'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_customer'           => (int)$this->request->getPost('id_customer'),
            'nama_customer'         => (string)$this->request->getPost('nama_customer'),
            'alamat_customer'       => (string)$this->request->getPost('alamat_customer'),
            'pic_nama_customer'     => (string)$this->request->getPost('pic_nama_customer'),
            'pic_no_customer'       => (string)$this->request->getPost('pic_no_customer'),
            'kode_customer'         => (string)$this->request->getPost('kode_customer')
        ];

        $customersModel = new CustomersModel;
        $customersModel->save($insertData);

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

        $find = (new CustomersModel)->find( $id );
        if($find) {

            (new CustomersModel)->delete($id);

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