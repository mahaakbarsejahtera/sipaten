<?php 

namespace App\Models;

use CodeIgniter\Model;

class PengajuanProyekItemModel extends Model
{
    
    protected $table = "pengajuan_proyek_item";
    protected $primaryKey = "id_pengajuan_proyek_item";
    
    protected $allowedFields = [
        'id_pengajuan_proyek','	pengajuan_proyek_name', 'pengajuan_proyek_desc',
        'pengajuan_proyek_qty', 'pengajuan_proyek_unit',
        'pengajuan_proyek_price', 'pengajuan_proyek_keterangan',
        'id_anggaran_item' 
    ];

    protected $orderby = [
        'id_pengajuan_proyek', 'pengajuan_proyek_name','pengajuan_proyek_price',
        'id_pengajuan_proyek_item'
    ];

    protected $filterby = [
        'id_pengajuan_proyek_item'  => 'pengajuan_proyek_item.id_pengajuan_proyek_item',
        'id_pengajuan_proyek'       => 'pengajuan_proyek_item.id_pengajuan_proyek',
        'id_anggaran_item'          => 'pengajuan_proyek_item.id_anggaran_item'
    ];



}   