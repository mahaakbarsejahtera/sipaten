<?php

namespace App\Controllers\Api;

use App\Models\PermintaanFileModel;
use CodeIgniter\Controller;

class PermintaanFile extends Controller
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

        $find = (new PermintaanFileModel)
            //->builder()
            //->join('permi', 'users.user_role=roles.id_role', 'left')
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
        


        
        $permintaanFileModel = new PermintaanFileModel();
        $permintaanFileModel->builder()
        ->select("

            permintaan.id_permintaan, permintaan.nama_pekerjaan, permintaan.permintaan_status,
            permintaan.permintaan_user, permintaan.permintaan_lokasi_survey, permintaan.permintaan_jadwal_survey,
            permintaan.date_create,

            users.id_user, users.user_fullname, users.user_name, users.user_status,

            survey.id_survey, survey.survey_user

        ")
        ->join('users', 'permintaan.permintaan_user=users.id_user', 'left')
        ->join('survey', 'permintaan.id_permintaan=survey.id_permintaan', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $permintaanFileModel->like('permintaan.nama_pekerjaan', $filter['value'])
                            ->orLike('permintaan.permintaan_lokasi_survey', $filter['value'])
                            ->orLike('permintaan.permintaan_jadwal_survey', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($permintaanFileModel->filterby))) {
                        $permintaanFileModel->where($filter['key'], $filter['valeu']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $permintaanFileModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $permintaanFileModel->paginate(10, 'group1');
        $pager = $permintaanFileModel->pager;

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
            'id_permintaan	'     => 'required',
            'nama_file'           => 'required',
            'lokasi_file'         => 'required',
           
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_permintaan'          => $this->request->getPost('id_permintaan'),
            'nama_file'              => $this->request->getPost('nama_file'),
            'lokasi_file'            => $this->request->getPost('lokasi_file')
        ];

        $permintaanFileModel = new PermintaanFileModel;
        $permintaanFileModel->save($insertData);

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
            'id_file'              => 'required',
            'id_permintaan'        => 'required', 
            'nama_file'            => 'required',
            'lokasi_file'          => 'required',
            
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_file'                 => $this->request->getPost('id_file'),
            'id_permintaan'           => $this->request->getPost('id_permintaan'),
            'nama_file'               => $this->request->getPost('nama_file'),
            'lokasi_file'             => $this->request->getPost('lokasi_file'),
           
        ];

        $permintaanFileModel = new PermintaanFileModel;
        $permintaanFileModel->save($insertData);

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

        $find = (new PermintaanFileModel)->find( $id );
        if($find) {

            (new PermintaanFileModel)->delete($id);

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