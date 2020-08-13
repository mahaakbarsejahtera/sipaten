<?php

namespace App\Controllers\Api;

use App\Models\HasilSurveyModel;
use CodeIgniter\Controller;

class HasilSurvey extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new HasilSurveyModel)->find( $id );

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
        


        
        $rolesModel = new HasilSurveyModel();

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
            'id_survey'     => 'required',
            'survey_item_name'     => 'required',
            'survey_item_qty'      => 'required',
            'survey_item_unit'      => 'required',
            'survey_harga_pokok'      => 'required',
            'survey_harga_jual'    => 'required',
            'survey_harga_pokok_nego'      => 'required',
            'survey_harga_jual_nego'      => 'required'

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
            'id_survey'     => $this->request->getPost('id_survey'),
            'survey_item_name'      => $this->request->getPost('survey_item_name'),
            'survey_item_qty'     => $this->request->getPost('survey_item_qty'),
            'survey_item_unit'     => $this->request->getPost('survey_item_unit'),
            'survey_harga_pokok'     => $this->request->getPost('survey_harga_pokok'),
            'survey_harga_jual'     => $this->request->getPost('survey_harga_jual'),
            'survey_harga_pokok_nego'     => $this->request->getPost('survey_harga_pokok_nego'),
            'survey_harga_jual_nego'     => $this->request->getPost('survey_harga_jual_nego'),

        ];


        $rolesModel = new HasilSurveyModel;
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
            'id_role'       => 'required',
            'role_name'     => 'required',
            'role_cap'      => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_role'       => $this->request->getPost('id_role'),
            'role_name'     => $this->request->getPost('role_name'),
            'role_cap'      => $this->request->getPost('role_cap'),
            'role_desc'     => $this->request->getPost('role_desc'),
        ];

        $rolesModel = new HasilSurveyModel;
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

        $find = (new HasilSurveyModel)->find( $id );
        if($find) {

            (new HasilSurveyModel)->delete($id);

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