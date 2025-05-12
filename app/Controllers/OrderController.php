<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use CodeIgniter\Controller;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
       
       
    }

    public function delete($id) 
    {

        $orderModel = new OrderModel();
        $orderitemModel = new OrderItemModel();
        $order = $orderModel->find($id);
        if (!$order) {
                return redirect()->back()->with('error', "Order with ID: {$id} not found.");
            }
        
        $orderModel->delete($id);
        $orderitemModel->delete($id);
        
            return redirect()->back()->with('success', 'Order deleted successfully.');
                
    }

    
    

   

}
