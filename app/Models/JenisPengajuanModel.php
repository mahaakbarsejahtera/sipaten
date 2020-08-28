<?php 

namespace App\Models;

use CodeIgniter\Model;

class JenisPengajuanModel extends Model
{

    protected $table = "jenis_pengajuan";
    protected $primaryKey = "id_jenis_pengajuan";
    protected $allowedFields = [
        'nama_jenis_pengajuan', 'kode_jenis_pengajuan', 'jenis_pengajuan_term'
    ];

    protected $orderby = [
        'id_jenis_pengajuan', 'nama_jenis_pengajuan'
    ];

    protected $filterby = [
        'id_jenis_pengajuan' => 'jenis_pengajuan.id_jenis_pengajuan',
        'nama_jenis_pengajuan' => 'jenis_pengajuan.nama_jenis_pengajuan',
        'kode_jenis_pengajuan' => 'jenis_pengajuan.kode_jenis_pengajuan',
        'jenis_pengajuan_term' => 'jenis_pengajuan.jenis_pengajuan_term',
    ];



}   