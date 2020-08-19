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

    // PEMASARAN


    public function pemasaranCustomer() {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Customer',
                'active' => true
            ],
        ])->render();
        
        return view('admin/pemasaran/customer', [
            'title' => 'Permintaan',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_customer',
                    'name' => 'Nama',
                    'sort' => true,
                ],
                [
                    'name' => 'PIC',
                ],
                [
                    'name' => 'Alamat',
                ],    
                [
                    'name' => 'Aksi'
                ],

            ])
            ->render("table-data")
        ]);

    }

    public function pemasaranPermintaan() {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Customer',
                'active' => true
            ],
        ])->render();
        
        return view('admin/pemasaran/permintaan', [
            'title' => 'Permintaan',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'name' => 'Customer',
                ],
                  
                [
                    'name' => 'Lokasi'
                ],
                [
                    'name' => 'Jadwal'
                ],
                [
                    'name' => 'Keterangan'
                ],
                [
                    'field' => 'permintaan_sales',
                    'name' => 'Sales',
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
                [
                    'name' => 'Hasil Survey'
                ],
                [
                    'name' => 'Estimasi Harga'
                ],
                [
                    'name' => 'Lampiran Penawaran'
                ],
                [
                    'name' => 'Aksi'
                ],

            ])
            ->render("table-data")
        ]);
    }

    public function pemasaranPenawaran() {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Penawaran',
                'active' => true
            ],
        ])->render();
        
        return view('admin/pemasaran/penawaran', [
            'title' => 'Penawaran',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'No Surat',
                ],
                [
                    'name' => 'Pekerjaan',
                ],
                [
                    'name' => 'Customer'
                ],
                [
                    'name' => 'Sales'
                ],
                [
                    'name' => 'Nilai Penawaran'
                ],
                [
                    'name' => 'Tanggal',
                ],  
                [
                    'name' => 'Kondisi Penawaran',
                ],

                [
                    'name' => 'Aksi'
                ],

            ])
            ->render("table-data")
        ]);
    }


    // TEKNIK

    public function teknikPermintaan() {
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
        
        return view('admin/teknik/permintaan', [
            'title' => 'Permintaan',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'name' => 'Customer',
                ],
                  
                [
                    'name' => 'Lokasi'
                ],
                [
                    'name' => 'Jadwal'
                ],
                [
                    'name' => 'Keterangan'
                ],
                [
                    'field' => 'permintaan_sales',
                    'name' => 'Sales',
                    'sort' => true,
                ],  
                [
                    'name' => 'Penunjukan'
                ],
                [
                    'name' => 'Status',
                ]

            ])
            ->render("table-data")
        ]);
    }

    public function teknikSurvey() {
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
        
        return view('admin/teknik/survey', [
            'title' => 'Survey',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'name' => 'Customer',
                ],
                  
                [
                    'name' => 'Lokasi'
                ],
                [
                    'name' => 'Jadwal'
                ],
                [
                    'name' => 'Keterangan'
                ],
                [
                    'field' => 'permintaan_sales',
                    'name' => 'Sales',
                    'sort' => true,
                ],  
                [
                    'name' => 'Hasil Survey'
                ],
                [
                    'name' => 'Status',
                ]

            ])
            ->render("table-data")
        ]);
    }

}