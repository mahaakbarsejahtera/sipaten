<?php

namespace App\Controllers\Api;

use App\Models\PenanggungJawabModel;
use CodeIgniter\Controller;

class PenanggungJawab extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new PenanggungJawabModel)->find( $id );

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
        
        
        $PenanggungJawabModel = new PenanggungJawabModel();
        $PenanggungJawabModel->builder()
        ->select("


            penanggung_jawab.id_penanggung_jawab, 
            penanggung_jawab.id_jenis_pengajuan,
            penanggung_jawab.sebagai_penanggung_jawab,
            penanggung_jawab.urutan_penanggung_jawab,
            penanggung_jawab.penanggung_jawab_user,
            
            users.user_code, users.user_name, users.user_fullname, 

            roles.id_role, roles.role_name, roles.role_cap
            
        ")
        ->join('users', 'penanggung_jawab.penanggung_jawab_user=users.id_user', 'left')
        ->join('roles', 'users.user_role=roles.id_role', 'left');
       
        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        //$PenanggungJawabModel->like('jenis_pengajuan.nama_jenis_pengajuan', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($PenanggungJawabModel->filterby))) {
                        $PenanggungJawabModel->where($PenanggungJawabModel->filterby[$filter['key']], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $PenanggungJawabModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $PenanggungJawabModel->paginate(10, 'group1');
        $pager = $PenanggungJawabModel->pager;

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
            'id_jenis_pengajuan'     => 'required',
            'penanggung_jawab_user' => 'required'

        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        
        $posisi = $this->getLastPosisi($this->request->getPost('id_jenis_pengajuan'));

        // Dinamis ikuti table
        $insertData = [
            'id_jenis_pengajuan'            => $this->request->getPost('id_jenis_pengajuan'),
            'penanggung_jawab_user'         => $this->request->getPost('penanggung_jawab_user'),
            'sebagai_penanggung_jawab'      => $this->request->getPost('sebagai_penanggung_jawab'),
            'urutan_penanggung_jawab'       => ++$posisi
        ];

        $db                  = db_connect();
        $PenanggungJawabModel = $db->table('penanggung_jawab');
        $PenanggungJawabModel->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_penanggung_jawab' => $db->insertID() ] + $insertData;
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
            'id_penanggung_jawab'       => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_penanggung_jawab'           => $this->request->getPost('id_penanggung_jawab'),
            'penanggung_jawab_user'         => $this->request->getPost('penanggung_jawab_user'),
            'id_jenis_pengajuan'            => $this->request->getPost('id_jenis_pengajuan'),
            'sebagai_penanggung_jawab'      => $this->request->getPost('sebagai_penanggung_jawab'),
        ];

        $PenanggungJawabModel = new PenanggungJawabModel;
        $PenanggungJawabModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
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

        $find = (new PenanggungJawabModel)->find( $id );
        if($find) {

            (new PenanggungJawabModel)->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        return $this->response->setJson($response);
    }

    public function getLastPosisi($jenis_pengajuan) 
    {
        $db = db_connect();
        $last_position = (int)$db
            ->table('penanggung_jawab')
            ->select("max(urutan_penanggung_jawab) as urutan")
            ->where('id_jenis_pengajuan', $jenis_pengajuan)
            ->get()
            ->getRow()->urutan;


        return $last_position;
    }

    public function tambahPenanggungJawab() 
    {   

        $response = [
            'data'      => [],
            'errors'    => [],
            'code'      => '',
            'message'   => '',
        ];

        $db = db_connect();
        
        $posisi = $this->getLastPosisi($this->request->getPost('id_jenis_pengajuan'));
        $insertData = [
            'id_jenis_pengajuan'      => $this->request->getPost('id_jenis_pengajuan'),
            'sebagai_penanggung_jawab' => $this->request->getPost('sebagai_penangung_jawab'),
            'urutan_penanggung_jawab' => ++$posisi,
        ];

        $saveData = $db->table('penanggung_jawab')->insert($insertData);

        if($saveData)
        {
            $response['code'] = 200;
            $response['data'] = [ 'id_penanggung_jawab' => $db->insertID() ] + $insertData;
            $response['message'] = 'Success';
        }

        return $this->response->setJSON($response);



    }


    public function deletePenanggungJawab($penanggung_jawab) 
    {
        $response = [
            'data'      => [],
            'errors'    => [],
            'code'      => '',
            'message'   => '',
        ];

        $db = db_connect();

        $find = $db->table('penanggung_jawab')
            ->where('id_penanggung_jawab', $penanggung_jawab)
            ->get()
            ->getRow();

        $delete = $db->table('penanggung_jawab')
        ->where('id_penanggung_jawab', $penanggung_jawab)
        ->delete();

        if($delete)
        {

            $response['code']       = 200;
            $response['data']       = $find;
            $response['message']    = 'Success';

        }

        return $this->response->setJSON($response);
    }

    public function urutkanPenanggungJawab() 
    {

        $response = [
            'data'      => [],
            'errors'    => [],
            'code'      => '',
            'message'   => '',
        ];

        $ids = $this->request->getPost('ids[]');
        $db = db_connect();
        $i = 0;
        foreach($ids as $id)
        {
            $db
            ->table('penanggung_jawab')
            ->where('id_penanggung_jawab', $id)
            ->update([ 'urutan_penanggung_jawab' => ++$i]);
        };

        $response['code']       = 200;
        $response['message']    = 'Success';
        
        return $this->response->setJSON($response);

    }

}