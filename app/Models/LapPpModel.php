<?php 

namespace App\Models;

use CodeIgniter\Model;

class LapPpModel extends Model
{
    
    protected $table = "lap_pp";
    protected $primaryKey = "id_lpp";
    
    protected $allowedFields = [
        'id_pp', 'status_lpp', 'acc_date'
    ];

    protected $orderby = [
        'id_lpp', 'id_pp','acc_date',
        'status_lpp', 
    ];

    protected $filterby = [
        'id_lpp'   => 'lap_pp.id_pengajuan_proyek',
        'id_pp'           => 'lap_pp.id_anggaran',
        'status_lpp'            => 'lap_pp.id_pengaju',
        'acc_date'    => 'lap_pp.id_jenis_pengajuan',

    ];



}   