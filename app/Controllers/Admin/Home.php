<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Home extends Controller
{

    public function estimasi() {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Estimasi',
                'active' => true
            ],
        ])->render();
        
        return view('admin/estimasi', [
            'title' => 'Survey',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'field' => 'survey_user',
                    'name' => 'Surveyour',
                    'sort' => true,
                ],    
                [
                    'field' => 'permintaan_status',
                    'name' => 'Status',
                    'sort' => true
                ],
                [
                    'name' => 'Aksi'
                ],

            ])
            ->render("table-data")
        ]);

    }

}