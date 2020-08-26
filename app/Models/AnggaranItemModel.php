<?php 

namespace App\Models;

use CodeIgniter\Model;

class AnggaranItemModel extends Model
{
    protected $table = "anggaran_item";
    protected $primaryKey = "id_anggaran_item";
    
    protected $allowedFields = [
        'id_anggaran','jenis_anggaran','anggaran_item',
        'anggaran_qty','anggaran_unit', 'anggaran_price'
    ];

    protected $orderby = [
        'id_anggaran_item',
        'id_anggaran','jenis_anggaran','anggaran_item',
        'anggaran_qty','anggaran_unit', 'anggaran_price'
    ];

    protected $filterby = [
        'id_anggaran_item'  => 'anggaran_item.id_anggaran_item',
        'id_anggaran'       => 'anggaran_item.id_anggaran',
        'anggaran_item'     =>'anggaran_item.anggaran_item',
        'anggaran_qty'      =>'anggaran_item.anggaran_qty',
        'anggaran_unit'     =>'anggaran_item.anggaran_unit',
        'anggaran_price'    =>'anggaran_item.anggaran_price'

    ];



}   