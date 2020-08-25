<?php 

namespace App\Models;

use CodeIgniter\Model;

class NegosiasiModel extends Model
{
    protected $table = "negosiasi";
    protected $primaryKey = "id_nego";
    protected $allowedFields = [

        'id_permintaan', 'id_permintaan', 'nego_term', 
        'nego_pic_nama', 'nego_pic_jabatan', 'date_created',
        'nego_no', 'nego_tgl_surat', 'nego_lokasi'

    ];

    protected $orderby = [
        'id_permintaan', 'id_nego'
    ];

    protected $filterby = [
        'id_nego'       => 'negosiasi.id_customer',
        'id_permintaan' => 'negosiasi.id_permintaan',
    ];



}   