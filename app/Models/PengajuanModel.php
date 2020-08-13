<?php 

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = "pengajuan";
    protected $primaryKey = "id_pengajuan";
    
    protected $allowedFields = [
        'id_anggaran','	id_jenis_pengajuan'
    ];

    protected $orderby = [
        'id_pengajuan', 'id_anggaran','id_jenis_pengajuan'
    ];

    protected $filterby = [
        'id_pengajuan' => 'pengajuan.id_pengajuan',
        'id_anggaran' => 'pengajuan.id_anggaran',
        'id_jenis_pengajuan' => 'pengajuan.id_jenis_pengajuan'
    ];



}   