<?php

namespace App\Models;

use CodeIgniter\Model;

class TempDataModel extends Model
{
    protected $table = 'temp_data'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['tableNumber', 'businessOwnerId']; 
}