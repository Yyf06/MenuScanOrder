<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuItemModel extends Model
{
    protected $table = 'Menu_Item';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'img', 'price', 'Category_ID', 'description', 'is_best_seller', 'businessowner_id', 'ai_description'];
    


    public function getMenuItems($ownerId)
    {
        return $this->where('businessowner_id', $ownerId)->findAll();
    }
}
