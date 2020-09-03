<?php

namespace App\Controllers\Api;

use App\Models\PengajuanProyekItemModel;
use CodeIgniter\Controller;

class PengajuanProyekItem extends Controller
{

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new PengajuanProyekItemModel)->find( $id );

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
        
        $pengajuanItemModel = new PengajuanProyekItemModel();
        $pengajuanItemModel->builder()
        ->join('anggaran_item', 'pengajuan_proyek_item.id_anggaran_item=anggaran_item.id_anggaran_item', 'left');

        $response['filters'] = $this->request->getGet('filters');
        if(!empty($this->request->getGet('filters'))) {

            foreach($this->request->getGet('filters') as $filter) {

                switch($filter['key']) {
                    
                    case 'search':
                       
                        $pengajuanItemModel->like('pengajuan_item.pengajuan_item_name', $filter['value']);

                    break;

                    default:
                    
                    if(in_array($filter['key'], array_keys($pengajuanItemModel->filterby))) {
                        $pengajuanItemModel->where($pengajuanItemModel->filterby[$filter['key']], $filter['value']);
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

        $errors = [];

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];

        // Dinamis ikuti table
        $rules = [
            'id_pengajuan_proyek'   => 'required',
            'id_anggaran_item'      => 'required'
        ];

        $message_rules = [
            'id_pengajuan_proyek'     =>  [
                'required'      => 'Item harus dipilih',
                //'outOfAnggaran' => 'Qty & Harga tidak boleh melebihi anggaran'
            ]
        ];

    
        if(!$this->validate($rules, $message_rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        
        $anggaran_item  = (new \App\Models\AnggaranItemModel())->find($this->request->getPost('id_anggaran_item'));

        $anggaran_unit  = $anggaran_item['anggaran_unit'];
        $anggaran_price = (double)$anggaran_item['anggaran_price'];
        $anggaran_qty   = (double)$anggaran_item['anggaran_qty'];
        $anggaran_total = (double)$anggaran_price * $anggaran_qty;

        $pengajuan_proyek_qty       = (double)$this->request->getPost('pengajuan_proyek_qty');
        $pengajuan_proyek_price     = (double)$this->request->getPost('pengajuan_proyek_price');
        $pengajuan_proyek_total     = (double)$pengajuan_proyek_qty * $pengajuan_proyek_price;

        $item   = (new \App\Models\PengajuanProyekItemModel())
                        ->builder()
                        ->select("
                            SUM(pengajuan_proyek_qty) as total_qty, 
                            SUM(pengajuan_proyek_price) as total_price
                        ")
                        ->where('id_pengajuan_proyek', $this->request->getPost('id_pengajuan_proyek'))
                        ->where('id_anggaran_item', $this->request->getPost('id_anggaran_item'))
                        ->get();
        $item_dipakai   = $item->getRow();
        $item_rows      = count($item->getResult());

        if($item_rows > 0)
        {

            $errors['num_rows'] = 'Item sudah ada';

        }
        

        $total_qty      = (double)$item_dipakai->total_qty;
        $total_price    = (double)$item_dipakai->total_price;


        if(!in_array(strtolower($anggaran_unit), [ 'ls', 'lot', 'lots' ])) 
        {
            
            if(($total_qty + $pengajuan_proyek_qty)  > $anggaran_qty) $errors['out_of_qty'] = "Quantity pengajuan tidak boleh melebihi {$anggaran_qty} {$anggaran_unit}";

        }

        if(($pengajuan_proyek_total + $total_price) > $anggaran_total) $errors['out_of_price'] = "Harga item pada pengajuan tidak boleh lebih besar dari {$anggaran_total}";

        


        if(count($errors) > 0)
        {
            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $errors;

            return $this->response->setJson($response); 
        }
    


        // Dinamis ikuti table
        $insertData = [
            'id_pengajuan_proyek'           => $this->request->getPost('id_pengajuan_proyek'),
            'id_anggaran_item'              => (int)$this->request->getPost('id_anggaran_item'),
            'pengajuan_proyek_name'         => (string)$this->request->getPost('pengajuan_proyek_name'),
            'pengajuan_proyek_desc'         => (string)$this->request->getPost('pengajuan_proyek_desc'),
            'pengajuan_proyek_qty'          => (double)$this->request->getPost('pengajuan_proyek_qty'),
            'pengajuan_proyek_unit'         => (string)$this->request->getPost('pengajuan_proyek_unit'),
            'pengajuan_proyek_price'        => (double)$this->request->getPost('pengajuan_proyek_price'),
            'pengajuan_proyek_keterangan'   => (string)$this->request->getPost('pengajuan_proyek_keterangan'),
            
        ];

        $db                 = db_connect();
        $pengajuanItemModel = $db
                                ->table('pengajuan_proyek_item')
                                ->insert($insertData);

        $afterInsert        = $db->table('pengajuan_proyek_item')
                                ->join('anggaran_item', 'pengajuan_proyek_item.id_anggaran_item=anggaran_item.id_anggaran_item', 'left')
                                ->where('pengajuan_proyek_item.id_pengajuan_proyek_item', $db->insertID())
                                ->get()
                                ->getRow();

        $response['code']       = 200;
        //$response['data']       = [ 'id_pengajuan_proyek_item' => $db->insertID() ] +  $insertData;
        $response['data']       = $afterInsert;
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
            'id_pengajuan_proyek_item'      => 'required',
            'id_anggaran_item'              => 'required'
        ];

        $message_rules = [
            'id_pengajuan_proyek_item'  => [
                'required' => 'Belum ada',
            ],
            'id_anggaran_item'          =>  [
                'outOfAnggaran' => 'Qty & Harga tidak boleh melebihi anggaran',
                'required'      => 'Item harus dipilih',
            ]
        ];
    
        if(!$this->validate($rules, $message_rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $anggaran_item  = (new \App\Models\AnggaranItemModel())->find($this->request->getPost('id_anggaran_item'));


        $anggaran_unit  = $anggaran_item['anggaran_unit'];
        $anggaran_price = (double)$anggaran_item['anggaran_price'];
        $anggaran_qty   = (double)$anggaran_item['anggaran_qty'];
        $anggaran_total = (double)$anggaran_price * $anggaran_qty;

        $pengajuan_proyek_qty       = (double)$this->request->getPost('pengajuan_proyek_qty');
        $pengajuan_proyek_price     = (double)$this->request->getPost('pengajuan_proyek_price');
        $pengajuan_proyek_total     = (double)$pengajuan_proyek_qty * $pengajuan_proyek_price;

        if(!in_array(strtolower($anggaran_unit), [ 'ls', 'lot', 'lots' ])) 
        {
            if($pengajuan_proyek_qty > $anggaran_qty) 
            {

                $response['code']       = 400;
                $response['message']    = 'Bad Request';
                $response['errors']     = [
                    'err' => "Quantity pengajuan tidak boleh melebihi {$anggaran_qty} {$anggaran_unit}"
                ];
    
                return $this->response->setJson($response); 

            }

        }
            
            

        if($pengajuan_proyek_total > $anggaran_total)
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = [
                'err' => "Harga item pada pengajuan tidak boleh lebih besar dari {$anggaran_total}"
            ];

            return $this->response->setJson($response);

        }


        $insertData = [
            'id_pengajuan_proyek_item'      => (int)$this->request->getPost('id_pengajuan_proyek_item'),
            'id_pengajuan_proyek'           => (int)$this->request->getPost('id_pengajuan_proyek'),
            'id_anggaran_item'              => (int)$this->request->getPost('id_anggaran_item'),
            'pengajuan_proyek_desc'         => (string)$this->request->getPost('pengajuan_proyek_desc'),
            'pengajuan_proyek_qty'          => (double)$this->request->getPost('pengajuan_proyek_qty'),
            'pengajuan_proyek_unit'         => (string)$this->request->getPost('pengajuan_proyek_unit'),
            'pengajuan_proyek_price'        => (double)$this->request->getPost('pengajuan_proyek_price'),
            'pengajuan_proyek_keterangan'   => (string)$this->request->getPost('pengajuan_proyek_keterangan'),
            
        ];

        $pengajuanItemModel = new PengajuanProyekItemModel;
        $pengajuanItemModel->save($insertData);

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

        $find = (new PengajuanProyekItemModel)->find( $id );
        if($find) {

            (new PengajuanProyekItemModel)->delete($id);

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