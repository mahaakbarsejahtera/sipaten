<?php 

namespace App\Models;

use CodeIgniter\Model;

class NegosiasiModel extends Model
{
    protected $table = "negosiasi";
    protected $primaryKey = "id_nego";
    protected $allowedFields = [

        'id_permintaan', 'id_permintaan', 'nego_term', 
        'nego_pic_nama', 'nego_pic_jabatan', 'date_created'

    ];

    protected $orderby = [
        'id_permintaan', 'id_permintaan'
    ];

    protected $filterby = [
        'id_nego'       => 'negosiasi.id_customer',
        'id_permintaan' => 'permintaan.id_permintaan',
    ];



}   