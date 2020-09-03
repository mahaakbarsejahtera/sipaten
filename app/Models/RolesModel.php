<?php 

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = "roles";
    protected $primaryKey = "id_role";
    protected $allowedFields = [
        'role_name', 'role_desc', 'role_cap'
    ];

    protected $orderby = [
        'id_role', 'role_name'
    ];

    protected $filterby = [
        'role_name' => 'roles.role_name',
        'role_cap' => 'roles.role_cap',
        'role_desc' => 'roles.role_desc'
    ];

    public function getjenisPengajuan($id_role) 
    {


        return $this->db->table('roles_pengajuan')
                ->select("roles_pengajuan.id_jenis_pengajuan, jenis_pengajuan.kode_jenis_pengajuan, jenis_pengajuan.nama_jenis_pengajuan")
                ->join('jenis_pengajuan', 'roles_pengajuan.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan', 'left')
                ->where('roles_pengajuan.id_role', $id_role)
                ->get()->getResult();

    }

}   