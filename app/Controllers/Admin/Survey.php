<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Survey extends Controller
{

    public function index()
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Survey',
                'active' => true
            ],
        ])->render();
        
        return view('admin/survey', [
            'title' => 'Permintaan',
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
                    'field' => 'survey_status',
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