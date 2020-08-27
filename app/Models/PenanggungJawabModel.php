<?php 

namespace App\Models;

use CodeIgniter\Model;

class PenanggungJawabModel extends Model
{
    protected $table = "penanggung_jawab";
    protected $primaryKey = "id_penanggung_jawab";
    protected $allowedFields = [

        'id_jenis_pengajuan', 'sebagai_penanggung_jawab', 'urutan_penanggung_jawab', 
        'penanggung_jawab_user'

    ];

    protected $orderby = [
        'id_penanggung_jawab', 'id_jenis_pengajuan'
    ];

    protected $filterby = [
        'id_penanggung_jawab'       => 'penanggung_jawab.id_penanggung_jawab',
        'id_jenis_pengajuan'        => 'penanggung_jawab.id_jenis_pengajuan',
        'sebagai_penanggung_jawab'  => 'penanggung_jawab.sebagai_penanggung_jawab',
        'urutan_penanggung_jawab'   => 'penanggung_jawab.urutan_penanggung_jawab',
        'penanggung_jawab_user'     => 'penanggung_jawab.penanggung_jawab_user'
    ];



}   