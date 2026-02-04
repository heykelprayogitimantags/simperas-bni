<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'asset_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'asset_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'asset_type' => [
                'type'       => 'ENUM',
                'constraint' => ['hardware', 'software'],
            ],
            'asset_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'brand' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'serial_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'purchase_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'warranty_end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['baik', 'rusak_ringan', 'rusak_berat', 'retired'],
                'default'    => 'baik',
            ],
            'specifications' => [
                'type' => 'TEXT',
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
        
        $this->forge->addKey('asset_id', true);
        $this->forge->createTable('assets');
    }

    public function down()
    {
        $this->forge->dropTable('assets');
    }
}