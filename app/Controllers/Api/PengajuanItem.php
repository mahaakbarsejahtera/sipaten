<?php

namespace App\Controllers\Api;

use App\Models\PengajuanItemModel;
use CodeIgniter\Controller;

class PengajuanItem extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new PengajuanItemModel)->find( $id );

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
        


        
        $pengajuanItemModel = new PengajuanItemModel();

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                       
                        $pengajuanItemModel->like('pengajuan_item.pengajuan_item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($pengajuanItemModel->filterby))) {
                        $response['filters'][] = $filter['key'];
                    }

                    break;
                }
                
            }

        }

        if(!empty($this->request->getGet('orders'))) {
            foreach($this->request->getGet('orders') as $order) {
                $response['orders'][] = $order['orderby'];
                $pengajuanItemModel->orderBy($order['orderby'], $order['order']);
            }
        }


        $lists = $pengajuanItemModel->paginate(10, 'group1');
        $pager = $pengajuanItemModel->pager;

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
            'id_pengajuan'      => 'required',
            'pengajuan_item_name'    => 'required',
            'pengajuan_qty'     => 'required',
            'pengajuan_unit'    => 'required',
            'pengajuan_price'   => 'required',

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
            'id_pengajuan'       => $this->request->getPost('id_pengajuan'),
            'pengajuan_item_name'     => $this->request->getPost('pengajuan_item_name'),
            'pengajuan_qty'      => $this->request->getPost('pengajuan_qty'),
            'pengajuan_unit'     => $this->request->getPost('pengajuan_unit'),
            'pengajuan_price'    => $this->request->getPost('pengajuan_price'),
            
        ];


        $pengajuanItemModel = new PengajuanItemModel;
        $pengajuanItemModel->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        $response['model']      = $pengajuanItemModel->getInsertID();
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
            'id_pengajuan_item'     => 'required',
            'id_pengajuan'          => 'required',
            'pengajuan_item_name'        => 'required',
            'pengajuan_qty'         => 'required',
            'pengajuan_unit'        => 'required',
            'pengajuan_price'       => 'required',
        ];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id_pengajuan_item'     => $this->request->getPost('id_pengajuan_item'),
            'id_pengajuan'          => $this->request->getPost('id_pengajuan'),
            'pengajuan_item_name'        => $this->request->getPost('pengajuan_item_name'),
            'pengajuan_qty'         => $this->request->getPost('pengajuan_qty'),
            'pengajuan_unit'        => $this->request->getPost('pengajuan_unit'),
            'pengajuan_price'       => $this->request->getPost('pengajuan_price'),
        ];

        $pengajuanItemModel = new PengajuanItemModel;
        $pengajuanItemModel->save($insertData);

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

        $find = (new PengajuanItemModel)->find( $id );
        if($find) {

            (new PengajuanItemModel)->delete($id);

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