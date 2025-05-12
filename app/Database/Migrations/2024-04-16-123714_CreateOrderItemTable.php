<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'primary' => true, 
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Order_Item');
    }

    

    public function down()
    {
        $this->forge->dropTable('Order_Item');
    }
}
