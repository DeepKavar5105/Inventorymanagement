<?php 
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'name', 'mobile', 'username', 'password', 'profile','user_type','created_at', 'updated_at'];
}
