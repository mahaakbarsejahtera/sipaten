<?php

namespace App\Controllers\Api;

use App\Models\JenisPengajuanModel;
use CodeIgniter\Controller;

class JenisPengajuan extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new JenisPengajuanModel)->find( $id );

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
        


        
        $jenisPengajuanModel = new JenisPengajuanModel();
        $jenisPengajuanModel->builder()
        ->select("


            jenis_pengajuan.id_jenis_pengajuan, 
            jenis_pengajuan.kode_jenis_pengajuan,
            jenis_pengajuan.nama_jenis_pengajuan,
            jenis_pengajuan.jenis_pengajuan_term,
           
        ");
       
        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $jenisPengajuanModel->like('jenis_pengajuan.nama_jenis_pengajuan', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($jenisPengajuanModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $jenisPengajuanModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $jenisPengajuanModel->paginate(10, 'group1');
        $pager = $jenisPengajuanModel->pager;

        $data = [];

        foreach($lists as $list)
        {


            $data[] = $list + [
                'penanggung_jawab' => (new \App\Models\PenanggungJawabModel())
                                        ->where('id_jenis_pengajuan', $list['id_jenis_pengajuan'])
                                        ->join('users', 'penanggung_jawab.penanggung_jawab_user = users.id_user', 'left')
                                        ->join('roles', 'users.user_role = roles.id_role', 'left')
                                        ->get()
                                        ->getResult()
            ];

        }

        $response['data']['lists'] = $data;
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
            'nama_jenis_pengajuan'     => 'required'

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
            'nama_jenis_pengajuan'     => $this->request->getPost('nama_jenis_pengajuan'),
            'kode_jenis_pengajuan'     => $this->request->getPost('kode_jenis_pengajuan'),
            'jenis_pengajuan_term'     => $this->request->getPost('jenis_pengajuan_term')
        ];

        $db                  = db_connect();
        $jenisPengajuanModel = $db->table('jenis_pengajuan');
        $jenisPengajuanModel->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_jenis_pengajuan' => $db->insertID() ] + $insertData;
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
            'id_jenis_pengajuan'       => 'required',
            'nama_jenis_pengajuan'     => 'required'
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_jenis_pengajuan'     => $this->request->getPost('id_jenis_pengajuan'),
            'kode_jenis_pengajuan'     => $this->request->getPost('kode_jenis_pengajuan'),
            'nama_jenis_pengajuan'   => $this->request->getPost('nama_jenis_pengajuan'),
            'jenis_pengajuan_term'   => $this->request->getPost('jenis_pengajuan_term'),
        ];

        $jenisPengajuanModel = new JenisPengajuanModel;
        $jenisPengajuanModel->save($insertData);

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

        $find = (new JenisPengajuanModel)->find( $id );
        if($find) {

            (new JenisPengajuanModel)->delete($id);

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