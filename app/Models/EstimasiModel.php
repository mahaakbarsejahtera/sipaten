<?php 

namespace App\Models;

use CodeIgniter\Model;

class EstimasiModel extends Model
{
    protected $table = "estimasi";
    protected $primaryKey = "id_estimasi";
    
    protected $allowedFields = [
        'id_permintaan', 'estimasi_approve_status', 'estimasi_approve_by'
    ];

    protected $orderby = [
        'id_estimasi', 'id_permintaan', 'estimasi_approve_status',
        '	estimasi_approve_by'
    ];

    protected $filterby = [
        'id_estimasi' => 'estimasi.id_estimasi',
        'id_permintaan' => 'estimasi.id_permintaan',
        'estimasi_approve_status' => 'permintaan.estimasi_approve_status',
        'estimasi_approve_by' => 'permintaan.estimasi_approve_by'
    ];



}   