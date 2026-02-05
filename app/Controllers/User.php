<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display user list
     */
   public function index()
{
    $keyword = $this->request->getGet('keyword');
    $role    = $this->request->getGet('role');
    $status  = $this->request->getGet('status');

    $users = $this->userModel
                  ->filterUsers($keyword, $role, $status)
                  ->paginate(10);

    $data = [
        'title' => 'Kelola User',
        'user' => [
            'full_name' => $this->session->get('full_name'),
            'role' => $this->session->get('role'),
            'department' => $this->session->get('department'),
        ],

        'users' => $users,
        'pager' => $this->userModel->pager,

        'keyword' => $keyword,
        'role_filter' => $role,
        'status_filter' => $status,

        // Statistics (query terpisah = AMAN)
        'total_users'    => $this->userModel->countAll(),
        'total_active'   => $this->userModel->where('is_active', 1)->countAllResults(),
        'total_admin'    => $this->userModel->where('role', 'admin')->countAllResults(),
        'total_teknisi'  => $this->userModel->where('role', 'teknisi')->countAllResults(),
        'total_pegawai'  => $this->userModel->where('role', 'pegawai')->countAllResults(),
    ];

    return view('user/index', $data);
}


    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah User',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
        ];

        return view('user/create', $data);
    }

    /**
     * Store new user
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'permit_empty|valid_email|is_unique[users.email]',
            'role' => 'required|in_list[admin,teknisi,pegawai]',
            'department' => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'department' => $this->request->getPost('department'),
            'is_active' => true,
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/user')
                           ->with('success', 'User berhasil ditambahkan');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan user');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')
                           ->with('error', 'User tidak ditemukan');
        }

        // Prevent editing own account
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/user')
                           ->with('error', 'Tidak dapat mengedit akun sendiri. Gunakan menu Profile.');
        }

        $data = [
            'title' => 'Edit User',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'edit_user' => $user,
        ];

        return view('user/edit', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')
                           ->with('error', 'User tidak ditemukan');
        }

        // Prevent editing own account
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/user')
                           ->with('error', 'Tidak dapat mengedit akun sendiri');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,user_id,{$id}]",
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => "permit_empty|valid_email|is_unique[users.email,user_id,{$id}]",
            'role' => 'required|in_list[admin,teknisi,pegawai]',
            'department' => 'permit_empty|max_length[100]',
        ];

        // Only validate password if provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'department' => $this->request->getPost('department'),
        ];

        // Update password only if provided
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/user')
                           ->with('success', 'User berhasil diperbarui');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui user');
        }
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')
                           ->with('error', 'User tidak ditemukan');
        }

        // Prevent deactivating own account
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/user')
                           ->with('error', 'Tidak dapat menonaktifkan akun sendiri');
        }

        $newStatus = !$user['is_active'];
        
        if ($this->userModel->update($id, ['is_active' => $newStatus])) {
            $message = $newStatus ? 'User berhasil diaktifkan' : 'User berhasil dinonaktifkan';
            return redirect()->to('/user')
                           ->with('success', $message);
        } else {
            return redirect()->to('/user')
                           ->with('error', 'Gagal mengubah status user');
        }
    }

    /**
     * Delete user (soft delete by deactivating)
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')
                           ->with('error', 'User tidak ditemukan');
        }

        // Prevent deleting own account
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/user')
                           ->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        // Check if user has tickets or maintenance logs
        $ticketModel = new \App\Models\TicketModel();
        $maintenanceModel = new \App\Models\MaintenanceLogModel();
        
        $hasTickets = $ticketModel->where('reported_by', $id)->countAllResults() > 0;
        $hasMaintenance = $maintenanceModel->where('technician_id', $id)->countAllResults() > 0;

        if ($hasTickets || $hasMaintenance) {
            // Deactivate instead of delete
            if ($this->userModel->update($id, ['is_active' => false])) {
                return redirect()->to('/user')
                               ->with('success', 'User tidak dapat dihapus karena memiliki data terkait. User telah dinonaktifkan.');
            }
        }

        // Actually delete if no related data
        if ($this->userModel->delete($id)) {
            return redirect()->to('/user')
                           ->with('success', 'User berhasil dihapus');
        } else {
            return redirect()->to('/user')
                           ->with('error', 'Gagal menghapus user');
        }
    }

    /**
     * Reset password
     */
    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')
                           ->with('error', 'User tidak ditemukan');
        }

        // Generate random password
        $newPassword = bin2hex(random_bytes(4)); // 8 character random password

        if ($this->userModel->update($id, ['password' => $newPassword])) {
            return redirect()->to('/user')
                           ->with('success', "Password berhasil direset menjadi: <strong>{$newPassword}</strong> (catat password ini!)");
        } else {
            return redirect()->to('/user')
                           ->with('error', 'Gagal mereset password');
        }
    }
}