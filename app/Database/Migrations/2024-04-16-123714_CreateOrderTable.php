<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'table_number' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'timestamp' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'number_of_dining' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'businessowner_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Order');

    }

    public function down()
    {
        $this->forge->dropTable('Order');
    }
}
