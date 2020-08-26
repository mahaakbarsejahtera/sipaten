<?php 

namespace App\Models;

use CodeIgniter\Model;

class PengajuanProyekModel extends Model
{
    
    protected $table = "pengajuan_proyek";
    protected $primaryKey = "id_pengajuan_proyek";
    
    protected $allowedFields = [
        'id_anggaran','	id_jenis_pengajuan', 
    ];

    protected $orderby = [
        'id_pengajuan', 'id_anggaran','id_jenis_pengajuan'
    ];

    protected $filterby = [
        'id_pengajuan'          => 'pengajuan.id_pengajuan',
        'id_anggaran'           => 'pengajuan.id_anggaran',
        'id_jenis_pengajuan'    => 'pengajuan.id_jenis_pengajuan'
    ];



}   