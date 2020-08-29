<?php 

namespace App\Models;

use CodeIgniter\Model;

class PengajuanInternalModel extends Model
{
    
    protected $table = "pengajuan_internal";
    protected $primaryKey = "id_pengajuan_internal";
    
    protected $allowedFields = [
        'id_jenis_pengajuan', 'id_pengaju',
        'perihal_pengajuan_internal', 'no_surat_pengajuan_internal',
        'tanggal_pengajuan_internal', 'due_date_pengajuan_internal' 
    ];

    protected $orderby = [
        'id_pengajuan_internal','id_pengaju',
        'id_jenis_pengajuan', 'perihal_pengajuan_internal', 'tanggal_pengajuan_internal',
        'due_date_pengajuan_internal'
    ];

    protected $filterby = [
        'id_pengajuan_internal'   => 'pengajuan_internal.id_pengajuan_internal',
        'id_pengaju'            => 'pengajuan_internal.id_pengaju',
    ];



}   