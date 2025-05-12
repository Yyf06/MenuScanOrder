<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameToOrderItem extends Migration
{
    public function up()
    {
        $this->forge->addColumn('Order_Item', [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100, 
                'null' => true,
                'after' => 'order_id' 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('Order_Item', 'name');
    }
}
