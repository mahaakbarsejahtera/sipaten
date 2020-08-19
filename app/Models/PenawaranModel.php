<?php 

namespace App\Models;

use CodeIgniter\Model;

class PenawaranModel extends Model
{
    protected $table = "permintaan";
    protected $primaryKey = "id_permintaan";
    
    protected $allowedFields = [
        'id_permintaan', 'penawaran_no', 'penawaran_due_date',
        'penawaran_validasi_date', 'penawaran_term',
        
    ];

    protected $orderby = [
        'id_penawaran', 'id_permintaan', 'penawaran_due_date', 'penawaran_validasi_date',
        'penawaran_term'
    ];

    protected $filterby = [
        'id_penawaran'  => 'penawaran.id_penawaran',
        'id_penawaran'  => 'penawaran.id_penawaran',
        'permintaan'    => 'permintaan.nama_pekerjaan'
    ];



}   