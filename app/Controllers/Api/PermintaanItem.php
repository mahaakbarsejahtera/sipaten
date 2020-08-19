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
        


        
        $permintaanItemsModel = new PermintaanItemsModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                        
                        $permintaanItemsModel->like('permintaan_item.item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($permintaanItemsModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                        $permintaanItemsModel->where($filter['key'], $filter['value']);
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $permintaanItemsModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $permintaanItemsModel->paginate(10, 'group1');
        $pager = $permintaanItemsModel->pager;

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
            'item_name'         => (string)$this->request->getPost('item_name'),
            'item_keterangan'   => (string)$this->request->getPost('item_keterangan'),
            'item_qty'          => (double)$this->request->getPost('item_qty'),
            'item_unit'         => $this->request->getPost('item_unit'),
            'item_hp'           => (int)$this->request->getPost('item_hp'),
            'item_hj'           => (int)$this->request->getPost('item_hj'),
            'item_hp_nego'      => (int)$this->request->getPost('item_hp_nego'),
            'item_hj_nego'      => (int)$this->request->getPost('item_hj_nego'),
        ];

        $db = db_connect();

        $rolesModel = $db->table('permintaan_item')
            ->insert($insertData);

        $response['code']       = 200;
        $response['data']       = [ 'id_item' => $db->insertID() ] + $insertData;
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
            'id_permintaan'     => (int)$this->request->getPost('id_permintaan'),
            'item_name'         => (string)$this->request->getPost('item_name'),
            'item_keterangan'   => (string)$this->request->getPost('item_keterangan'),
            'item_qty'          => (double)$this->request->getPost('item_qty'),
            'item_unit'         => $this->request->getPost('item_unit'),
            'item_hp'           => (int)$this->request->getPost('item_hp'),
            'item_hj'           => (int)$this->request->getPost('item_hj'),
            'item_hp_nego'      => (int)$this->request->getPost('item_hp_nego'),
            'item_hj_nego'      => (int)$this->request->getPost('item_hj_nego'),
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

    public function updateEstimasi() {
        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [
            'id_item'       => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_item'           => (int)$this->request->getPost('id_item'),
            'item_hp'           => (int)$this->request->getPost('item_hp'),
            'item_hj'           => (int)$this->request->getPost('item_hj'),
            'item_hp_nego'      => (int)$this->request->getPost('item_hp_nego'),
            'item_hj_nego'      => (int)$this->request->getPost('item_hp_nego'),
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

    public function updateBoq() 
    {
        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [
            'id_item'       => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_item'           => (int)$this->request->getPost('id_item'),
            'item_name'         => (string)$this->request->getPost('item_name'),
            'item_qty'           => (int)$this->request->getPost('item_qty'),
            'item_unit'           => (string)$this->request->getPost('item_unit'),
        ];

        $rolesModel = new PermintaanItemsModel;
        $rolesModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
    }

}