<?php 

namespace App\Models;

use CodeIgniter\Model;

class CustomersModel extends Model
{
    protected $table = "customers";
    protected $primaryKey = "id_customer";
    protected $allowedFields = [
        'nama_customer', 'alamat_customer', 'pic_nama_customer',
        'pic_no_customer', 'kode_customer'
    ];

    protected $orderby = [
        'id_customer', 'nama_customer'
    ];

    protected $filterby = [
        'nama_customer' => 'customers.nama_customer',
        'alamat_customer' => 'customers.alamat_customer',
        'pic_nama_customer' => 'customers.pic_nama_customer',
        'pic_no_customer' => 'customers.pic_no_customer',
    ];
    
}   