<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserSubscriptionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'subscription_plan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'start_date' => [
                'type' => 'TIMESTAMP',
            ],
            'end_date' => [
                'type' => 'TIMESTAMP',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable('user_subscriptions');

    }

    public function down()
    {
        $this->forge->dropTable('user_subscriptions');
    }
}
