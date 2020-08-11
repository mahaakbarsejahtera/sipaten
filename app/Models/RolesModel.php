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
}   