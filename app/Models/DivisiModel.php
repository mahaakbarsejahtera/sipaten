<?php 

namespace App\Models;

use CodeIgniter\Model;

class DivisiModel extends Model
{
    protected $table = "divisi";
    protected $primaryKey = "id_divisi";
    protected $allowedFields = [
        'nama_divisi'
    ];

    protected $orderby = [
        'id_divisi', 'divisi_name'
    ];

    protected $filterby = [
        'id_divisi' => 'divisi.id_divisi',
        'nama_divisi' => 'divisi.nama_divisi',
    ];



}   