<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;

class Pengajuan extends Controller
{

    // Anggaran

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

        return view('admin/pengajuan/pemasaran/operasional', [
        'title' => 'Pengajuan Proyek',
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

    public function pemasaranOperasionalProyek()
    {
        $breadcrumb = (new BreadCrumb)->set([
            [
                'name' => 'Dashboard',
                'url' => base_url('dashboard'),
            ],
            [
                'name' => 'Pengajuan Operasional Pemasaran',
                'active' => true
            ],
        ])->render();

        return view('admin/pengajuan/pemasaran/operasional', [
            'title' => 'Pengajuan Operasional Pemasaran',
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

    // Non Anggaran

    public function pengajuanNonAnggaran() {
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




}