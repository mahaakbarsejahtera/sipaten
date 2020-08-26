<?php 

namespace App\Models;

use CodeIgniter\Model;

class PengajuanInternalModel extends Model
{
    
    protected $table = "pengajuan_internal";
    protected $primaryKey = "id_pengajuan_internal";
    
    protected $allowedFields = [
        'id_jenis_pengajuan'
    ];

    protected $orderby = [
        'id_pengajuan_internal', 'id_jenis_pengajuan'
    ];

    protected $filterby = [
        'id_pengajuan_internal'   => 'pengajuan_internal.id_pengajuan_internal',
        'id_jenis_pengajuan'      => 'pengajuan_internal.id_jenis_pengajuan'
    ];



}   