<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPERAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #fb923c;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }

        /* Smooth transitions only */
        * {
            transition: all 0.2s ease;
        }

        /* Remove transition from animations */
        button, input, .alert-box {
            transition: all 0.2s ease;
        }

        /* Simple fade in */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Loading spinner */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        /* Background gradient */
        body {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        /* Logo container - FIXED */
        .logo-container {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin: 0 auto;
            padding: 20px;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Card styling */
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        /* Input focus */
        input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        /* Button hover */
        .btn-primary:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md fade-in">
        <!-- Logo Container -->
        <div class="text-center mb-6">
            <div class="logo-container">
                <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo SIMPERAS">
            </div>
            <h2 class="mt-6 text-white text-2xl font-bold">
                SIMPERAS
            </h2>
            <p class="text-orange-50 text-sm mt-1">
                Sistem Informasi Manajemen Perawatan & Aset
            </p>
        </div>

        <!-- Login Card -->
        <div class="login-card overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white text-center">
                <h1 class="text-xl font-bold mb-1">Selamat Datang</h1>
                <div class="w-12 h-0.5 bg-white/50 mx-auto my-2 rounded-full"></div>
                <p class="text-orange-50 text-sm">PT Bank Negara Indonesia (Persero) Tbk</p>
                <p class="text-orange-100/80 text-xs mt-0.5">Unit Logistics & Human Capital</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                
                <!-- Error Alert -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg alert-box">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <p class="ml-3 text-red-700 text-sm flex-1"><?= session()->getFlashdata('error') ?></p>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Success Alert -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg alert-box">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <p class="ml-3 text-green-700 text-sm flex-1"><?= session()->getFlashdata('success') ?></p>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-green-400 hover:text-green-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="<?= base_url('login') ?>" method="POST" id="loginForm" class="space-y-5">
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-orange-500"></i>Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                value="<?= old('username') ?>"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white"
                                placeholder="Masukkan username Anda"
                                required
                                autofocus
                            >
                        </div>
                        <?php if (isset($errors['username'])): ?>
                            <p class="mt-1 text-xs text-red-500">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['username'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1 text-orange-500"></i>Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white"
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 focus:outline-none"
                                aria-label="Toggle password visibility"
                            >
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <p class="mt-1 text-xs text-red-500">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['password'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 cursor-pointer">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                        <a href="<?= base_url('forgot-password') ?>" class="text-sm text-orange-600 hover:text-orange-700 font-medium hover:underline">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="btn-primary w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-lg font-semibold shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
                    </button>

                </form>
                <div class="space-y-3">
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-orange-900 mb-1">Informasi Sistem</h4>
                                <p class="text-xs text-orange-700 leading-relaxed">
                                    Gunakan kredensial yang telah diberikan oleh administrator sistem. 
                                    Untuk bantuan, hubungi IT Support di ext219.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white space-y-2">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-building text-orange-200"></i>
                <p class="text-sm font-medium">
                    &copy; <?= date('Y') ?> PT Bank Negara Indonesia (Persero) Tbk
                </p>
            </div>
            <p class="text-xs text-orange-100">
                All Rights Reserved • Secure Login Portal V001
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission handler
        const loginForm = document.getElementById('loginForm');
        const submitBtn = loginForm.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        loginForm.addEventListener('submit', function(e) {
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner spinner mr-2"></i>Memproses...';
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-box');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);

        // Enter key navigation
        document.getElementById('username').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        });

        // Prevent multiple form submissions
        let isSubmitting = false;
        loginForm.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
        });
    </script>

</body>
</html>