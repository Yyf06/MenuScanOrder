<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Define the User table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'collation' => 'utf8mb4_general_ci',
                'null' => FALSE,
            ],
            'password_hashed' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'collation' => 'utf8mb4_general_ci',
                'null' => FALSE,
            ],
            'usertype' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'collation' => 'utf8mb4_general_ci',
                'null' => FALSE,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'collation' => 'utf8mb4_general_ci',
                'null' => TRUE,
                'default' => NULL,
            ],
            'isadmin' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => TRUE,
                'default' => 0,
            ],
            'business_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'collation' => 'utf8mb4_general_ci',
                'null' => TRUE,
                'default' => NULL,
            ],
            'business_type' => [
                'type' => 'ENUM',
                'constraint' => ['restaurant', 'cafe'],
                'collation' => 'utf8mb4_general_ci',
                'null' => TRUE,
                'default' => NULL,
            ],
            'business_address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'collation' => 'utf8mb4_general_ci',
                'null' => TRUE,
                'default' => NULL,
            ],
            'total_tables' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => NULL,
            ],
        ]);

        $this->forge->addKey('id', TRUE); 
        $this->forge->createTable('users'); 
    }

    public function down()
    {
        // Drop the User table if needed
        $this->forge->dropTable('users');
    }

}