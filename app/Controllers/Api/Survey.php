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
            'id_permintaan'            => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_permintaan'         => $this->request->getPost('id_permintaan'),
            'survey_user'           => $this->request->getPost('survey_user'),
            'survey_approve_status' => $this->request->getPost('survey_approve_status'),
            'survey_approve_by'     => $this->request->getPost('survey_approve_by'),
        ];

        $db = db_connect();

        $surveyModel = $db->table('survey');
        $surveyModel->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_survey' => $db->insertID() ] + $insertData;
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

    public function addItems() {

        $response = [
            'code'      => 0,
            'message'   => '',
            'data'      => [],
            'erroors'   => []
        ];

        $db = db_connect();

        $items  = $this->request->getPost('survey_item_name');
        $quantities = $this->request->getPost('survey_item_qty');
        $units      = $this->request->getPost('survey_item_unit');

        $temp = [];
        for($i = 0; $i < count($items); $i++) 
        {

            $item = isset($items[$i]) ? $items[$i] : '';
            $qty = isset($quantities[$i]) ? $quantities[$i] : 0;
            $unit = isset($units[$i]) ? $units[$i] : '';
            
            $dataToInsert = [
                'survey_item_name'  => $item,
                'survey_item_unit'  => $qty,
                'survey_item_qty'   => $unit 
            ];

            $temp[] = $dataToInsert;

            $db->table('hasil_survey')
            ->insert($dataToInsert);

        }


        $response['data']['items'] = $temp;
        $response['code'] = 200;
        $response['message'] = 'Success';


        return $this->response->setJson($response);

    }

    public function addItem() {
        
        $response = [
            'code'      => 0,
            'message'   => '',
            'data'      => [],
            'erroors'   => []
        ];

        $id_survey              = $this->request->getPost('id_survey');
        $survey_item_name       = $this->request->getPost('survey_item_name');
        $survey_item_qty        = $this->request->getPost('survey_item_qty');
        $survey_item_unit       = $this->request->getPost('survey_item_unit');

        
        $db = db_connect();

        $dataToInsert = [
            'id_survey' => $id_survey,
            'survey_item_name'      => $survey_item_name,
            'survey_item_qty'      => $survey_item_qty,
            'survey_item_unit'      => $survey_item_unit
        ];

        $db->table('hasil_survey')
            ->insert($dataToInsert);

        $response['data']['item']   = [ 'id_survey_item' => $db->insertID() ] + $dataToInsert;
        $response['code']           = 200;
        $response['message']        = 'Success';


        return $this->response->setJson($response);
    }

    public function loadItems() {
        
        $response = [
            'code'      => 200,
            'data'      => [],
            'errors'    => [],
            'message'   => '',
        ];

        $db = db_connect();

        $id_survey = $this->request->getGet('id_survey');

        $results = $db->table('hasil_survey')
            ->where('id_survey', $id_survey)
            ->get()
            ->getResult();

        $response['data']['lists'] = $results;

        return $this->response->setJson($response);

    }

    public function deleteItem( $id ) {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $db = db_connect();

        $find = $db->table('hasil_survey')
            ->where('id_survey_item', $id)
            ->get()->getRow();

        if($find) {

            $db->table('hasil_survey')->delete([
                'id_survey_item' => $id
            ]);

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