<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuCategoriesTable extends Migration
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
            'businessowner_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true, 
            ],
        ]);
    
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Menu_Categories');
    }

    public function down()
    {
        $this->forge->dropTable('Menu_Categories');
    }
}
