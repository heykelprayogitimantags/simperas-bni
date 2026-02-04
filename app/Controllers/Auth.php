<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Process login
     */
    public function attemptLogin()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyUser($username, $password);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah');
        }

        // Set session
        $sessionData = [
            'user_id'    => $user['user_id'],
            'username'   => $user['username'],
            'full_name'  => $user['full_name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'department' => $user['department'],
            'isLoggedIn' => true,
        ];

        $this->session->set($sessionData);

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/dashboard/admin');
            case 'teknisi':
                return redirect()->to('/dashboard/teknisi');
            case 'pegawai':
                return redirect()->to('/dashboard/pegawai');
            default:
                return redirect()->to('/dashboard');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout');
    }

    /**
     * Check if user is logged in (for AJAX)
     */
    public function checkSession()
    {
        if ($this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => true,
                'user' => [
                    'username'  => $this->session->get('username'),
                    'full_name' => $this->session->get('full_name'),
                    'role'      => $this->session->get('role'),
                ]
            ]);
        }

        return $this->response->setJSON(['status' => false]);
    }
}