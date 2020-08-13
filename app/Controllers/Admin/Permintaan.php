<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Permintaan extends Controller
{

    public function index()
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Permintaan',
                'active' => true
            ],
        ])->render();
        
        return view('admin/permintaan', [
            'title' => 'Permintaan',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'field' => 'permintaan_user',
                    'name' => 'Requested By',
                    'sort' => true,
                ],    
                [
                    'field' => 'permintaan_status',
                    'name' => 'Status',
                    'sort' => true
                ],
                [
                    'name' => 'Tanggal Permintaan',
                ],
                [ 'name' => 'BOQ' ],
                //[ 'name' => 'Berkas' ],
                [
                    'name' => 'Aksi'
                ],

            ])
            ->render("table-data")
        ]);
    }

}