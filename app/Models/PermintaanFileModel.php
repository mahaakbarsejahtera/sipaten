<?php 

namespace App\Models;

use CodeIgniter\Model;

class PermintaanFileModel extends Model
{
    protected $table = "permintaan_file";
    protected $primaryKey = "id_file";
    
    protected $allowedFields = [
        'id_permintaan','nama_file','lokasi_file'
    ];

    protected $orderby = [
        'id_file', 'id_permintaan','nama_file','lokasi_file'
    ];

    protected $filterby = [
        'id_file' => 'permintaan_file.id_file',
        'id_permintaan' => 'permintaan_file.id_permintaan',
        'nama_file' => 'permintaan_file.nama_file',
        'lokasi_file'=>'permintaan_file.lokasi_file'
    ];
    

 
}   