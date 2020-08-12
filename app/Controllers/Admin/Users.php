<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;

class Users extends Controller
{

    public function index()
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => '#',
            ],
            [
                'name' => 'Users',
                'url' => '#',
            ],
        ])->render();
        
    return view('Admin/users', [
            'title' => 'Users',
            'breadcrumb' => $breadcrumb
        ]);
    }

}