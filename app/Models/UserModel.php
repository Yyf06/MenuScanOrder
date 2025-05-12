<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password_hashed', 'email', 'usertype','isadmin',
    'business_name',      
    'business_type',     
    'business_address', 
    'total_tables' ];
}
