<?php

namespace App\Controllers\Api;

use App\Models\SurveyModel;
use CodeIgniter\Controller;

class Survey extends Controller
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

        $find = (new SurveyModel)
            //->builder()
            ->join('permintaan', 'survey.id_permintaan=permintaan.id_permintaan', 'left')
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
        


        
        $surveyModel = new SurveyModel();
        $surveyModel->builder()->join('permintaan', 'survey.id_permintaan=permintaan.id_permintaan', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $surveyModel->like('permintaan.nama_pekerjaan', $filter['value'])
                            ->orLike('permintaan.permintaan_lokasi_survey', $filter['value'])
                            ->orLike('permintaan.permintaan_jadwal_survey', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($surveyModel->filterby))) {
                        $surveyModel->where($filter['key'], $filter['valeu']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $surveyModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $surveyModel->paginate(10, 'group1');
        $pager = $surveyModel->pager;

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
            'nama_pekerjaan'            => 'required',
            'permintaan_user'           => 'required',
            'permintaan_status'         => 'required',
            'permintaan_lokasi_survey'  => 'required',
            'permintaan_jadwal_survey'  => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'nama_pekerjaan'               => $this->request->getPost('nama_pekerjaan'),
            'permintaan_user'              => $this->request->getPost('permintaan_user'),
            'permintaan_status'            => $this->request->getPost('permintaan_status'),
            'permintaan_lokasi_survey'     => $this->request->getPost('permintaan_lokasi_survey'),
            'permintaan_jadwal_survey'     => $this->request->getPost('permintaan_jadwal_survey'),
            'date_create'                  => date('Y-m-d')
        ];

        $surveyModel = new SurveyModel;
        $surveyModel->save($insertData);

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
            'id_permintaan'             => 'required',
            'nama_pekerjaan'            => 'required',
            'permintaan_user'           => 'required',
            'permintaan_status'         => 'required',
            'permintaan_lokasi_survey'  => 'required',
            'permintaan_jadwal_survey'  => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_permintaan'                 => $this->request->getPost('id_permintaan'),
            'nama_pekerjaan'               => $this->request->getPost('nama_pekerjaan'),
            'permintaan_user'              => $this->request->getPost('permintaan_user'),
            'permintaan_status'            => $this->request->getPost('permintaan_status'),
            'permintaan_lokasi_survey'     => $this->request->getPost('permintaan_lokasi_survey'),
            'permintaan_jadwal_survey'     => $this->request->getPost('permintaan_jadwal_survey'),
        ];

        $surveyModel = new SurveyModel;
        $surveyModel->save($insertData);

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

        $find = (new SurveyModel)->find( $id );
        if($find) {

            (new SurveyModel)->delete($id);

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


}