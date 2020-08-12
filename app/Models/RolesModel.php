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



}   