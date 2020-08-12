<?php 

namespace App\Models;

use CodeIgniter\Model;

class PengajuanItemModel extends Model
{
    protected $table = "pengajuan_item";
    protected $primaryKey = "id_pengajuan_item";
    
    protected $allowedFields = [
        'id_pengajuan','pengajuan_item','pengajuan_qty',
        'pengajuan_unit','pengajuan_price'
    ];

    protected $orderby = [
        'id_pengajuan_item', 'id_pengajuan','pengajuan_item',
        'pengajuan_qty','pengajuan_unit','pengajuan_price'
    ];

    protected $filterby = [
        'id_pengajuan_item' => 'pengajuan_item.id_pengajuan_item',
        'id_pengajuan' => 'pengajuan_item.id_pengajuan',
        'pengajuan_item' =>'pengajuan_item.pengajuan_item',
        'pengajuan_qty'=>'pengajuan_item.pengajuan_qty',
        'pengajuan_unit'=>'pengajuan_item.pengajuan_unit',
        'pengajuan_price'=>'pengajuan_item.pengajuan_price'

    ];



}   