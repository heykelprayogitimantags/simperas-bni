<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPERAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Animated background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo Container */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-box {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo-box:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 15px 50px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .app-title {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.5px;
        }

        .app-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 14px;
            font-weight: 500;
        }

        /* Card */
        .login-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        /* Header */
        .card-header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 32px 24px;
            text-align: center;
            color: white;
        }

        .card-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .card-header p {
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.95);
        }

        .card-header p.subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 4px;
        }

        /* Form */
        .form-container {
            padding: 40px 32px;
        }

        /* Alert */
        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            color: #166534;
        }

        .alert i {
            margin-right: 12px;
            font-size: 16px;
        }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.5;
            transition: opacity 0.2s;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-label i {
            color: #f97316;
            margin-right: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-input:focus {
            outline: none;
            border-color: #f97316;
            background: white;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.08);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .form-input:focus + .input-icon {
            color: #f97316;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 6px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #f97316;
        }

        .form-error {
            margin-top: 8px;
            font-size: 12px;
            color: #ef4444;
            display: flex;
            align-items: center;
        }

        .form-error i {
            margin-right: 4px;
        }

        /* Remember & Forgot */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #f97316;
        }

        .checkbox-wrapper label {
            font-size: 14px;
            color: #4b5563;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 14px;
            color: #f97316;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #ea580c;
            text-decoration: underline;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-submit i {
            margin-right: 8px;
        }

        /* Info Box */
        .info-box {
            margin-top: 24px;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            border: 1px solid #fed7aa;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            gap: 12px;
        }

        .info-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }

        .info-content h4 {
            font-size: 13px;
            font-weight: 700;
            color: #9a3412;
            margin-bottom: 6px;
        }

        .info-content p {
            font-size: 12px;
            color: #9a3412;
            line-height: 1.5;
        }

        .info-content strong {
            font-weight: 700;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 24px;
            color: white;
        }

        .footer-main {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .footer-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Loading spinner */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
            }

            .logo-box {
                width: 100px;
                height: 100px;
            }

            .app-title {
                font-size: 28px;
            }

            .form-container {
                padding: 32px 24px;
            }

            .card-header {
                padding: 28px 20px;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <!-- Logo Section -->
        <div class="logo-wrapper">
            <div class="logo-box">
                <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo SIMPERAS">
            </div>
            <h2 class="app-title">SIMPERAS</h2>
            <p class="app-subtitle">Sistem Informasi Manajemen Perawatan & Aset</p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            
            <!-- Header -->
            <div class="card-header">
                <h1>Selamat Datang</h1>
                <div class="divider"></div>
                <p>PT Bank Negara Indonesia (Persero) Tbk</p>
                <p class="subtitle">Unit Logistics & Human Capital</p>
            </div>

            <!-- Form -->
            <div class="form-container">
                
                <!-- Error Alert -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= session()->getFlashdata('error') ?></span>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Success Alert -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?= session()->getFlashdata('success') ?></span>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="<?= base_url('login') ?>" method="POST" id="loginForm">
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div class="form-group">
                        <label class="form-label" for="username">
                            <i class="fas fa-user"></i>Username
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                value="<?= old('username') ?>"
                                class="form-input"
                                placeholder="Masukkan username Anda"
                                required
                                autofocus
                            >
                            <i class="fas fa-user input-icon"></i>
                        </div>
                        <?php if (isset($errors['username'])): ?>
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= $errors['username'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i>Password
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input"
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <i class="fas fa-lock input-icon"></i>
                            <button 
                                type="button" 
                                class="toggle-password"
                                onclick="togglePassword()"
                                aria-label="Toggle password visibility"
                            >
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= $errors['password'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-footer">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Ingat Saya</label>
                        </div>
                        <a href="<?= base_url('forgot-password') ?>" class="forgot-link">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-sign-in-alt"></i>Masuk ke Sistem
                    </button>

                </form>

                <!-- Info Box -->
                <div class="info-box">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-content">
                        <h4>Informasi Sistem</h4>
                        <p>Gunakan kredensial yang telah diberikan oleh administrator sistem. Untuk bantuan, hubungi IT Support di <strong>ext. 219</strong>.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-main">
                <i class="fas fa-building"></i>
                <span>&copy; <?= date('Y') ?> PT Bank Negara Indonesia (Persero) Tbk</span>
            </div>
            <div class="footer-sub">
                All Rights Reserved • Secure Login Portal V1.0.0
            </div>
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
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }
            
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner spinner"></i>Memproses...';
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
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
    </script>

</body>
</html>