<?php 

namespace App\Models;

use CodeIgniter\Model;

class LaporanPengajuanInternalItemModel extends Model
{
    
    protected $table = "pengajuan_internal_item";
    protected $primaryKey = "id_pengajuan_internal_item";
    
    protected $allowedFields = [
        'id_pengajuan_internal','	pengajuan_internal_name', 'pengajuan_internal_desc',
        'pengajuan_internal_qty', 'pengajuan_internal_unit',
        'pengajuan_internal_price', 'pengajuan_internal_keterangan',
        'pengajuan_internal_actual_price',
        'pengajuan_internal_actual_qty',
        'pengajuan_internal_actual_keterangan',
    ];

    protected $orderby = [
        'id_pengajuan_internal', 'pengajuan_internal_name','pengajuan_internal_price',
        'id_pengajuan_internal_item'
    ];

    protected $filterby = [
        'id_pengajuan_internal_item'  => 'pengajuan_internal_item.id_pengajuan_internal_item',
        'id_pengajuan_internal'       => 'pengajuan_internal_item.id_pengajuan_internal',
    ];



}   