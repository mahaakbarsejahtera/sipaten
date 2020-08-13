<?php

namespace App\Controllers\Api;

use App\Models\EstimasiModel;
use CodeIgniter\Controller;

class Estimasi extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new EstimasiModel)->find( $id );

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
        


        
        $rolesModel = new EstimasiModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $rolesModel->like('roles.role_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($rolesModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $rolesModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $rolesModel->paginate(10, 'group1');
        $pager = $rolesModel->pager;

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
            'id_permintaan'     => 'required',
            'estimasi_approve_status'     => 'required',
            'estimasi_approve_by'      => 'required',
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
            'id_permintaan'     => $this->request->getPost('id_permintaan'),
            'estimasi_approve_status'      => $this->request->getPost('estimasi_approve_status'),
            'estimasi_approve_by'     => $this->request->getPost('estimasi_approve_by')
        ];

        $rolesModel = new EstimasiModel;
        $rolesModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $rolesModel->getInsertID();
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
            'id_estimasi'       => 'required',
            'id_permintaan'     => 'required',
            'estimasi_approve_status'      => 'required',
            'estimasi_approve_by'      => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_estimasi'       => $this->request->getPost('id_estimasi'),
            'id_permintaan'     => $this->request->getPost('id_permintaan'),
            'estimasi_approve_status'      => $this->request->getPost('estimasi_approve_status'),
            'estimasi_approve_by'     => $this->request->getPost('estimasi_approve_by'),
        ];

        $rolesModel = new EstimasiModel;
        $rolesModel->save($insertData);

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

        $find = (new EstimasiModel)->find( $id );
        if($find) {

            (new EstimasiModel)->delete($id);

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