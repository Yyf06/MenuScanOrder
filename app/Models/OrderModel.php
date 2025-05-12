<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_id', 'table_number', 'timestamp', 'status', 'number_of_dining', 'businessowner_id'];

    public function getPendingOrders($businessowner_id)
{
    return $this->where('businessowner_id', $businessowner_id)
                ->where('status', 'Pending')
                ->findAll();
}

public function getPastOrders($businessowner_id)
{
    return $this->where('businessowner_id', $businessowner_id)
                ->where('status', 'Completed')
                ->findAll();
}

    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class);
    }
}
