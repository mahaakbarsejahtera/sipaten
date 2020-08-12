<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Users extends Controller
{

    public function index()
    {

        $breadcrumb = (new BreadCrumb)->set([
            [ 'name'  => 'Dashboard', 'url'   => base_url('dashboard') ],
            [ 'name' => 'Users', 'active' => true]
        ])->render();

        
        return view('admin/users', [
            'title' => 'Users',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [ 'field' => 'user_name', 'name' => 'Nama Lengkap', 'sort' => true ],
                [ 'field' => 'user_email', 'name' => 'Email' ],
                [ 'name' => 'Role' ],
                [ 'name' => 'Status' ],
                [ 'name' => 'Aksi' ]
            ])
            ->render("table-data")
        ]);
    }

}