<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password',
        'full_name',
        'email',
        'role',
        'department',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username'  => 'required|min_length[3]|max_length[50]|is_unique[users.username,user_id,{user_id}]',
        'email'     => 'permit_empty|valid_email|is_unique[users.email,user_id,{user_id}]',
        'password'  => 'required|min_length[6]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'role'      => 'required|in_list[admin,teknisi,pegawai]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'Username harus diisi',
            'min_length'  => 'Username minimal 3 karakter',
            'is_unique'   => 'Username sudah digunakan',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
            'is_unique'   => 'Email sudah digunakan',
        ],
        'password' => [
            'required'    => 'Password harus diisi',
            'min_length'  => 'Password minimal 6 karakter',
        ],
        'full_name' => [
            'required'    => 'Nama lengkap harus diisi',
        ],
        'role' => [
            'required'    => 'Role harus dipilih',
            'in_list'     => 'Role tidak valid',
        ],
    ];

    protected $skipValidation = false;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    /**
     * Verify user credentials
     */
    public function verifyUser($username, $password)
    {
        $user = $this->where('username', $username)
                     ->where('is_active', true)
                     ->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    /**
     * Get user by ID
     */
    public function getUserById($userId)
    {
        return $this->find($userId);
    }

    /**
     * Get all users by role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
                    ->where('is_active', true)
                    ->findAll();
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('is_active', true)->findAll();
    }

    /**
     * Deactivate user
     */
    public function deactivateUser($userId)
    {
        return $this->update($userId, ['is_active' => false]);
    }

    /**
     * Activate user
     */
    public function activateUser($userId)
    {
        return $this->update($userId, ['is_active' => true]);
    }
}