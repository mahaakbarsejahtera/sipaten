<?php 

namespace App\Models;

use CodeIgniter\Model;

class PicModel extends Model
{
    protected $table = "pic";
    protected $primaryKey = "id_pic";
    protected $allowedFields = [

        'id_customer', 'nama_pic', 'divisi_pic', 'jabatan_pic', 'kontak_pic'
    ];

    protected $orderby = [
        'id_pic', 'id_customer'
    ];

    protected $filterby = [
        'id_customer'   => 'pic.id_customer',
        'nama_pic'      => 'pic.role_cap',
        'divisi_pic'    => 'pic.role_desc',
        'jabatan_pic'   => 'pic.jabatan_pic',
        'kontak_pic'    => 'pic.kontak_pic'
    ];



}   