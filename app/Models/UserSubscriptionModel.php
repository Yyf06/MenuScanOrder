<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSubscriptionModel extends Model
{
    protected $table = 'user_subscriptions';
    protected $primaryKey = 'user_id ';
    protected $allowedFields = ['subscription_plan', 'start_date', 'end_date', 'status'];
}
