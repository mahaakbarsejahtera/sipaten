<?php 

namespace App\Models;

use CodeIgniter\Model;

class AnggaranModel extends Model
{
    protected $table = "anggaran";
    protected $primaryKey = "id_anggaran";
    
    protected $allowedFields = [
        'id_permintaan', 'approval_teknik', 'approval_pemasaran','approval_keuangan'
    ];

    protected $orderby = [
        'id_anggaran', 'id_permintaan', 'approval_teknik', 'approval_pemasaran',
        'approval_keuangan'
    ];

    protected $filterby = [
        'id_anggaran' => 'anggaran.id_anggaran',
        'id_permintaan' => 'anggaran.id_permintaan',
        'approval_teknik' => 'anggaran.approval_teknik',
        'approval_pemasaran' => 'anggaran.approval_pemasaran',
        'approval_keuangan' => 'anggaran.approval_keuangan'
    ];



}   