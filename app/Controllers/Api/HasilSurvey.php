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
        


        
        $hasilSurveyModel = new HasilSurveyModel();
        $hasilSurveyModel->builder()
        ->select("


            hasil_survey.id_survey_item, hasil_survey.id_survey, hasil_survey.survey_item_name, 
            hasil_survey.survey_item_qty, hasil_survey.survey_item_unit, hasil_survey.survey_harga_pokok,
            hasil_survey.survey_harga_jual,hasil_survey.survey_harga_pokok_nego,hasil_survey.	survey_harga_jual_nego,

            survey.id_permintaan, survey.survey_user, survey.survey_approve_status, survey.survey_approve_by
           
        ")
        ->join('survey', 'hasil_survey.id_survey=survey.id_survey', 'left');
        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $hasilSurveyModel->like('hasil_survey.survey_item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($hasilSurveyModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $hasilSurveyModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $hasilSurveyModel->paginate(10, 'group1');
        $pager = $hasilSurveyModel->pager;

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
            'id_survey'                  => $this->request->getPost('id_survey'),
            'survey_item_name'           => $this->request->getPost('survey_item_name'),
            'survey_item_qty'            => $this->request->getPost('survey_item_qty'),
            'survey_item_unit'           => $this->request->getPost('survey_item_unit'),
            'survey_harga_pokok'         => $this->request->getPost('survey_harga_pokok'),
            'survey_harga_jual'          => $this->request->getPost('survey_harga_jual'),
            'survey_harga_pokok_nego'    => $this->request->getPost('survey_harga_pokok_nego'),
            'survey_harga_jual_nego'     => $this->request->getPost('survey_harga_jual_nego'),

        ];


        $hasilSurveyModel = new HasilSurveyModel;
        $hasilSurveyModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $hasilSurveyModel->getInsertID();
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
            'id_survey_item'            => 'required',
            'id_survey'                 => 'required',
            'survey_item_name'          => 'required',
            'survey_item_qty'           => 'required',
            'survey_item_unit'          => 'required',
            'survey_harga_pokok'        => 'required',
            'survey_harga_jual'         => 'required',
            'survey_harga_pokok_nego'   => 'required',
            'survey_harga_jual_nego'    => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_survey_item'        => $this->request->getPost('id_survey_item'),
            'id_survey'             => $this->request->getPost('id_survey'),
            'survey_item_name'      => $this->request->getPost('survey_item_name'),
            'survey_item_qty'       => $this->request->getPost('survey_item_qty'),
            'survey_item_unit'      => $this->request->getPost('survey_item_unit'),
            'survey_harga_pokok'    => $this->request->getPost('survey_harga_pokok'),
            'survey_harga_jual'     => $this->request->getPost('survey_harga_jual'),
            'survey_harga_pokok_nego'  => $this->request->getPost('survey_harga_pokok_nego'),
            'survey_harga_jual_nego'   => $this->request->getPost('survey_harga_jual_nego'),
        ];

        $hasilSurveyModel = new HasilSurveyModel;
        $hasilSurveyModel->save($insertData);

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