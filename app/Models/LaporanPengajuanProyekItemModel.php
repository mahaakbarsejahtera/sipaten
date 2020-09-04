<?php 

namespace App\Models;

use CodeIgniter\Model;

class LaporanPengajuanProyekItemModel extends Model
{
    
    protected $table = "pengajuan_proyek";
    protected $primaryKey = "id_pengajuan_proyek";
    
    protected $allowedFields = [
        'id_anggaran', 'id_jenis_pengajuan', 'id_pengaju',
        'perihal_pengajuan_proyek', 'no_surat_pengajuan_proyek',
        'tanggal_pengajuan_proyek', 'due_date_pengajuan_proyek',
        'pengajuan_proyek_actual_qty', 'pengajuan_proyek_actual_price'
    ];

    protected $orderby = [
        'id_pengajuan_proyek', 'id_anggaran','id_pengaju',
        'id_jenis_pengajuan', 'perihal_pengajuan_proyek', 'tanggal_pengajuan_proyek',
        'due_date_pengajuan_proyek', 'pengajuan_proyek_actual_price'
    ];

    protected $filterby = [
        'id_pengajuan_proyek'               => 'pengajuan_proyek.id_pengajuan_proyek',
        'id_anggaran'                       => 'pengajuan_proyek.id_anggaran',
        'id_pengaju'                        => 'pengajuan_proyek.id_pengaju',
        'id_jenis_pengajuan'                => 'pengajuan_proyek.id_jenis_pengajuan',
        'pengajuan_proyek_actual_qty'       => 'pengajuan_proyek.pengajuan_proyek_actual_qty',
        'pengajuan_proyek_actual_price'     => 'pengajuan_proyek.pengajuan_proyek_actual_price',

    ];



}   