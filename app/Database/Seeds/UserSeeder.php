<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name'  => 'Administrator',
                'email'      => 'admin@bni.co.id',
                'role'       => 'admin',
                'department' => 'IT',
                'is_active'  => true,
            ],
            [
                'username'   => 'teknisi',
                'password'   => password_hash('teknisi123', PASSWORD_DEFAULT),
                'full_name'  => 'Teknisi IT',
                'email'      => 'teknisi@bni.co.id',
                'role'       => 'teknisi',
                'department' => 'IT',
                'is_active'  => true,
            ],
            [
                'username'   => 'pegawai',
                'password'   => password_hash('pegawai123', PASSWORD_DEFAULT),
                'full_name'  => 'Pegawai Test',
                'email'      => 'pegawai@bni.co.id',
                'role'       => 'pegawai',
                'department' => 'Finance',
                'is_active'  => true,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}