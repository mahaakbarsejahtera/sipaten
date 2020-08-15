<?php

namespace App\Controllers\Api;

use App\Models\PermintaanItemsModel;
use CodeIgniter\Controller;

class PermintaanItem extends Controller
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

        $find = (new PermintaanItemsModel)->find( $id );

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
        


        
        $rolesModel = new PermintaanItemsModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $rolesModel->like('permintaan_item.item_name', $filter['value']);

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


        $rules = [
            'id_permintaan'     => 'required',
            'item_name'         => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_permintaan'     => $this->request->getPost('id_permintaan'),
            'item_name'      => $this->request->getPost('item_name'),
            'item_keterangan'     => $this->request->getPost('item_keterangan'),
            'item_qty'     => $this->request->getPost('item_qty'),
            'item_unit'     => $this->request->getPost('item_unit'),
            'item_hp'     => $this->request->getPost('item_hp'),
            'item_hj'       => $this->request->getPost('item_hj'),
            'item_hp_nego'     => $this->request->getPost('item_hp_nego'),
            'item_hj_nego'     => $this->request->getPost('item_hj_nego'),
        ];

        $db = db_connect();

        $rolesModel = $db->table('permintaan_item')
            ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id' => $db->insertID() ] + $insertData;
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
            'id_item'       => 'required',
            'id_permintaan' => 'required',
            'item_name'     => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_item'           => $this->request->getPost('id_item'),
            'id_permintaan'     => $this->request->getPost('id_permintaan'),
            'item_name'         => $this->request->getPost('item_name'),
            'item_keterangan'   => $this->request->getPost('item_keterangan'),
            'item_qty'          => $this->request->getPost('item_qty'),
            'item_unit'         => $this->request->getPost('item_unit'),
            'item_hp'           => $this->request->getPost('item_hp'),
            'item_hj'           => $this->request->getPost('item_hj'),
            'item_hp_nego'      => $this->request->getPost('item_hp_nego'),
            'item_hj_nego'      => $this->request->getPost('item_hj_nego'),
        ];

        $rolesModel = new PermintaanItemsModel;
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

        $find = (new PermintaanItemsModel)->find( $id );
        if($find) {

            (new PermintaanItemsModel)->delete($id);

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