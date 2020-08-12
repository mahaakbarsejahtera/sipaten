<?php 

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = "users";
    protected $primaryKey = "id_user";
    protected $allowedFields = [
        'user_name', 'user_fullname', 'user_email', 'user_pass', 'user_role',
        'user_status', 'user_image', 'create_date', 'latest_update'
    ];

    protected $orderby = [
        'id_user', 'user_name', 'user_fullname', 'user_email'
    ];

    protected $filterby = [
        'user_name' => 'users.user_name',
        'user_fullname' => 'users.user_fullname',
        'user_email' => 'users.user_email'
    ];
    
}   