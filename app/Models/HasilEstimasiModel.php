<?php 

namespace App\Models;

use CodeIgniter\Model;

class HasilEstimasiModel extends Model
{
    protected $table = "hasil_estimasi";
    protected $primaryKey = "id_estimasi_item";
    
    protected $allowedFields = [
        'id_estimasi', 'estimasi_item_name', 'estimasi_item_qty',
        'estimasi_item_unit', 'estimasi_harga_pokok', 'estimasi_harga_jual',
        'estimasi_harga_pokok_nego', 'estimasi_harga_jual_nego'
    ];

    protected $orderby = [
        'id_estimasi_item', 'id_estimasi', 'estimasi_item_name',
        'estimasi_item_qty', 'estimasi_item_unit', 'estimasi_harga_pokok',
        'estimasi_harga_jual', 'estimas_harga_pokok_nego','estimasi_harga_jual_nego'
    ];

    protected $filterby = [
        'id_estimasi_item' => 'hasil_estimasi.id_estimasi_item',
        'id_estimasi' => 'hasil_estimasi.id_estimasi',
        'estimasi_item_name' => 'hasil_estimasi_id.estimasi_item_name',
        'estimasi_item_qty' => 'hasil_estimasi_id.estimasi_item_qty',
        'estimasi_item_unit' => 'hasil_estimasi_id.estimasi_item_unit',
        'estimasi_harga_pokok' => 'hasil_estimasi_id.estimasi_harga_pokok',
        'estimasi_harga_jual'=> 'hasil_estimasi_id.estimasi_harga_jual',
        'estimas_harga_pokok_nego' => 'hasil_estimasi_id.estimasi_harga_pokok_nego',
        'estimasi_harga_jual_nego' => 'hasil_estimasi_id.estimasi_harga_jual_nego'
    ];



}   