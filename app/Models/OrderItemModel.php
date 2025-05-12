<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'Order_Item';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'quantity', 'amount']; 
    
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }
}