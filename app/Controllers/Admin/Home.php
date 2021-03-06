<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Home extends Controller
{

    public function estimasi() 
    {

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
    public function pemasaranCustomer() 
    {

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

    public function pemasaranPermintaan() 
    {
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
                    'name' => 'Kontrak/SPPK/PO'
                ],
                [
                    'name' => 'Aksi'
                ],

            ])
            ->render("table-data")
        ]);
    }

    public function pemasaranPenawaran() 
    {
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
                    'name' => 'No Surat',
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

    public function pemasaranNegoisasi() 
    {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Negosiasi',
                'active' => true
            ],
        ])->render();
        
        return view('admin/pemasaran/negosiasi', [
            'title' => 'Negosiasi',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [ 'name' => 'No Surat' ],
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

    public function teknikPermintaan() 
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

    public function teknikSurvey() 
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

    public function teknikAnggaran() 
    {
       
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Anggaran',
                'active' => true
            ],
        ])->render();

        return view('admin/teknik/anggaran', [
            'title' => 'Anggaran',
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
                    'name' => 'Anggaran',
                ]

            ])
            ->render("table-data")
        ]);

    }


    public function dashboardJenisPengajuan() 
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Jenis Pengajuan',
                'active' => true
            ],
        ])->render();

        return view('admin/jenis-pengajuan', [
            'title' => 'Jenis Pengajuan',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'nama_jenis_pengajuan',
                    'name' => 'Nama Pengajuan',
                    'sort' => true,
                ],
                [
                    'name' => 'Kode'
                ],
                [
                    'name' => 'Ketentuan',
                ],
                [
                    'name' => 'Penanggung Jawab'
                ], 
                [
                    'name' => 'Aksi'
                ]

            ])
            ->render("table-data")
        ]);
    }

    public function pemasaranPengajuanOperasional() 
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Pengajuan',
                'active' => true
            ],
        ])->render();

        return view('admin/pengajuan/pemasaran/operasional', [
            'title' => 'Pengajuan',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'perihal_pengajuan_proyek',
                    'name' => 'Perihal',
                    'sort' => true,
                ],
                [
                    'name' => 'Tanggal Pengajuan'
                ],
                [
                    'name' => 'Due Date Pengajuan'
                ],
                [
                    'name' => ' Nilai Pengajuan'
                ],
                [
                    'name' => 'Pengaju'
                ],
                [
                    'name' => 'Nama Pekerjaan',
                ],
                //['name' => 'Penanggung Jawab'], 
                [
                    'name' => 'Anggaran'
                ],
                [
                    'name' => 'Aksi'
                ]

            ])
            ->render("table-data")
        ]);
    }

    public function pengajuanAnggaran() 
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Pengajuan Proyek',
                'active' => true
            ],
        ])->render();

        return view('admin/pengajuan-proyek', [
            'title' => 'Pengajuan Proyek',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'id_anggaran',
                    'name' => 'Perihal',
                    'sort' => true,
                ],
                [
                    'name' => 'Nomor Surat',
                ],
                [
                    'name' => 'Tanggal Pengajuan'
                ],
                [
                    'name' => 'Due Date Pengajuan'
                ],
                [
                    'name' => ' Nilai Pengajuan'
                ],
                [
                    'name' => 'Pengaju'
                ],
                [
                    'name' => 'Anggaran'
                ],
                [
                    'name' => 'Aksi'
                ]

            ])
            ->render("table-data")
        ]);

    }

    public function pengajuanNonAnggaran() 
    {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Pengajuan Internal',
                'active' => true
            ],
        ])->render();

        return view('admin/pengajuan-internal', [
            'title' => 'Pengajuan Internal',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'perihal_pengajuan_internal',
                    'name' => 'Perihal',
                    'sort' => true,
                ],
                [
                    'name' => 'Tanggal Pengajuan'
                ],
                [
                    'name' => 'Due Date Pengajuan'
                ],
                [
                    'name' => ' Nilai Pengajuan'
                ],
                [
                    'name' => 'Pengaju'
                ],
                // [
                //     'name' => 'Nama Pekerjaan',
                // ],
                //['name' => 'Penanggung Jawab'], 
                [
                    'name' => 'Aksi'
                ]

            ])
            ->render("table-data")
        ]);
    }


    // Laporan
    public function dashboardLaporanPengajuanProyek() 
    {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Laporan Pengajuan Proyek',
                'active' => true
            ],
        ])->render();

        return view('admin/laporan/pp', [
            'title' => 'Laporan Pengajuan Proyek',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'id_anggaran',
                    'name' => 'Perihal',
                    'sort' => true,
                ],
                [
                    'name' => 'Nomor Surat',
                ],
                [
                    'name' => 'Tanggal Pengajuan'
                ],
                [
                    'name' => 'Due Date Pengajuan'
                ],
                [
                    'name' => ' Nilai Pengajuan'
                ],
                [
                    'name' => 'Pengaju'
                ],
                // [
                //     'name' => 'Anggaran'
                // ],
                [
                    'name' => 'Aksi'
                ]

            ])
            ->render("table-data")
        ]);
    }

    public function dashboardLaporanPengajuanInternal() 
    {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Laporan Pengajuan Internal',
                'active' => true
            ],
        ])->render();

        return view('admin/laporan/pi', [
            'title' => 'Laporan Pengajuan Internal',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([
                [
                    'field' => 'perihal_pengajuan_internal',
                    'name' => 'Perihal',
                    'sort' => true,
                ],
                [
                    'name' => 'Nomor Surat',
                ],
                [
                    'name' => 'Tanggal Pengajuan'
                ],
                [
                    'name' => 'Due Date Pengajuan'
                ],
                [
                    'name' => ' Nilai Pengajuan'
                ],
                [
                    'name' => 'Pengaju'
                ],
                // [
                //     'name' => 'Anggaran'
                // ],
                [
                    'name' => 'Aksi'
                ]

            ])
            ->render("table-data")
        ]);
    }

    public function arsipProyek()
    {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Arsip Proyek',
                'active' => true
            ],
        ])->render();
        
        return view('admin/arsip-proyek', [
            'title' => 'Arsip Proyek',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([

                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'name' => 'Anggaran'
                ],
                [
                    'name' => 'Total Pengajuan' 
                ],
                [
                    'name' => 'Penawaran'
                ],
                [
                    'name' => 'Nego'
                ],
                [
                    'name' => 'Dokumen'
                ],
                [
                    'name' => 'Pengajuan'
                ],

            ])
            ->render("table-data")
        ]);
    }

    public function arsipProyekPengajuan($id_anggaran)
    {
       
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Arsip Proyek',
                'url' => base_url('dashboard/arsip-proyek'),
            ],
            [
                'name' => 'Pengajuan',
                'active' => true
            ]
        ])->render();

        $data = [
            'title'      => 'Arsip Pengajuan Proyek',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([

                [
                    'name' => 'Nomor Surat'
                ],
                [
                    'name' => 'Jenis Pengajuan' 
                ],
                [
                    'name' => 'Tanggal Pengajuan'
                ],
                [
                    'name' => 'Total Pengajuan'
                ],
                [
                    'name' => 'Total Actual'
                ]

            ])
            ->render("table-data"),
            'id_anggaran' => $id_anggaran
        ];

        return view('admin/arsip-proyek-pengajuan', $data);
    }

    public function dashboardTimeline()
    {

        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Timeline',
                'active' => true
            ],
        ])->render();
        
        return view('admin/timeline', [
            'title' => 'Timeline',
            'breadcrumb' => $breadcrumb,
            'table'         => (new Table())->setColumns([

                [
                    'field' => 'nama_pekerjaan',
                    'name' => 'Nama Pekerjaan',
                    'sort' => true,
                ],
                [
                    'name' => 'Anggaran'
                ],
                [
                    'name' => 'Total Pengajuan' 
                ],
                [
                    'name' => 'Penawaran'
                ],
                [
                    'name' => 'Nego'
                ],
                [
                    'name' => 'Dokumen'
                ],
                [
                    'name' => 'Pengajuan'
                ],

            ])
            ->render("table-data")
        ]);

    }

}