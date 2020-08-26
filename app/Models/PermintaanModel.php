<?php 

namespace App\Models;

use CodeIgniter\Model;

class PermintaanModel extends Model
{
    protected $table = "permintaan";
    protected $primaryKey = "id_permintaan";
    
    protected $allowedFields = [
        'id_customer', 'no_permintaan', 'no_survey', 'no_kontrak', 'nama_pekerjaan', 
        'keterangan_pekerjaan', 'id_pic', 'permintaan_status', 'permintaan_sales', 
        'permintaan_lokasi_survey', 'permintaan_jadwal_survey', 'permintaan_approval', 
        'permintaan_supervisi_status', 'permintaan_supervisi',
        'permintaan_hasil_survey_status', 'permintaan_nego', 'permintaan_kontrak',
        'approve_by', 'date_create'
        
    ];

    protected $orderby = [
        'id_permintaan', 'permintaan_status', 'permintaan_status',
        'date_create'
    ];

    protected $filterby = [
        'no_survey' => 'permintaan.no_survey',
        'no_kontrak' => 'permintaan.no_kontrak',
        'no_permintaan' => 'permintaan.no_permintaan',
        'permintaan_status' => 'permintaan.permintaan_status'
    ];



}   