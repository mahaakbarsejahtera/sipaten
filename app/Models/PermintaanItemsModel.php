<?php 

namespace App\Models;

use CodeIgniter\Model;

class PermintaanItemsModel extends Model
{
    protected $table = "permintaan_item";
    protected $primaryKey = "id_item";
    protected $allowedFields = [
        'id_permintaan', 'item_name', 'item_keterangan',
        'item_qty', 'item_unit', 'item_hp', 'item_hj', 
        'item_hp_nego', 'item_hj_nego', 'item_divisi'
    ];

    protected $orderby = [
        'id_item', 'id_permintaan', 'item_name' 
    ];

    protected $filterby = [
        'id_item' => 'permintaan_item.id_item',
        'item_name' => 'permintaan_item.item_name',
        'id_permintaan' => 'permintaan_item.id_permintaan'
    ];



}   