<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaintenanceLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'log_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ticket_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'asset_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'technician_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'diagnosis' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'action_taken' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'parts_used' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'start_time' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('log_id', true);
        
        // Foreign Keys
        $this->forge->addForeignKey('ticket_id', 'tickets', 'ticket_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('asset_id', 'assets', 'asset_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('technician_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('maintenance_logs');
    }

    public function down()
    {
        $this->forge->dropTable('maintenance_logs');
    }
}