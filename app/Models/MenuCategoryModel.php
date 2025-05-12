<?php


namespace App\Models;

use CodeIgniter\Model;

class MenuCategoryModel extends Model
{
    protected $table = 'Menu_Categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'businessowner_id'];
}
