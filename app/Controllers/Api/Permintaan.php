<?php

namespace App\Controllers\Api;

use App\Models\PermintaanModel;
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

        $find = (new PermintaanModel)
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
        


        
        $permintaanModel = new PermintaanModel();
        $permintaanModel->builder()
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
                        
                        $permintaanModel->like('permintaan.nama_pekerjaan', $filter['value'])
                            ->orLike('permintaan.permintaan_lokasi_survey', $filter['value'])
                            ->orLike('permintaan.permintaan_jadwal_survey', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($permintaanModel->filterby))) {
                        $permintaanModel->where($filter['key'], $filter['valeu']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $permintaanModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $permintaanModel->paginate(10, 'group1');
        $pager = $permintaanModel->pager;

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

        $permintaanModel = new PermintaanModel;
        $permintaanModel->save($insertData);

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

        $permintaanModel = new PermintaanModel;
        $permintaanModel->save($insertData);

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

        $find = (new PermintaanModel)->find( $id );
        if($find) {

            (new PermintaanModel)->delete($id);

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

        
        $response = [
            'data'      => [],
            'errors'    => [],
            'code'      => 0,
            'message'   => ''
        ];


        $rules = [
            'id_user'      => 'required',
            'user_pass' => 'required',
        ];

        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }


        $insertData = [
            'id_user' => $this->request->getPost('id_user'),
            'user_pass' => md5($this->request->getPost('user_pass'))
        ];

        (new PermintaanModel)->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);

    }

}