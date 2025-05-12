<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuItemTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'Category_ID' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_best_seller' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'businessowner_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true, 
            ],
            'ai_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Menu_Item');
    }

    public function down()
    {
        $this->forge->dropTable('Menu_Item');
    }
}
