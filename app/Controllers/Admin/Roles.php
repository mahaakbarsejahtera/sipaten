<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Roles extends Controller
{

    public function index()
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Roles',
                'active' => true
            ],
        ])->render();
        
        return view('Admin/roles', [
            'title' => 'Roles',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'role_name',
                    'name' => 'Nama',
                    'sort' => true,
                ],
                [
                    'field' => 'role_cap',
                    'name' => 'Kapasitas',
                ],
                [
                    'name' => 'Deskripsi',
                ],
                [
                    'name' => 'Aksi',
                ]
            ])
            ->render("table-data")
        ]);
    }

}