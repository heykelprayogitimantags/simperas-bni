<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPERAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .input-focus-glow:focus {
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .shimmer {
            background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.3) 50%, transparent 100%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

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

        /* Logo animation */
        .logo-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Pattern background */
        .pattern-bg {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 gradient-animate min-h-screen flex items-center justify-center p-4 relative overflow-hidden pattern-bg">
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white opacity-5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        
        <!-- Animated circles -->
        <div class="absolute top-1/4 right-1/4 w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
        <div class="absolute bottom-1/3 left-1/4 w-2 h-2 bg-white/30 rounded-full animate-ping" style="animation-delay: 1s;"></div>
        <div class="absolute top-2/3 right-1/3 w-2 h-2 bg-white/30 rounded-full animate-ping" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10 animate-fadeInUp">
        <!-- Logo Container -->
        <div class="text-center mb-8">
            <div class="inline-block animate-float">
                <div class="bg-white rounded-full p-6 shadow-2xl hover-lift relative">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 opacity-20 blur-xl"></div>
                    <i class="fas fa-tools text-6xl text-orange-500 relative z-10"></i>
                </div>
            </div>
            <h2 class="mt-4 text-white text-xl font-bold tracking-wider drop-shadow-lg">
                SIMPERAS
            </h2>
            <p class="text-orange-50 text-sm font-medium drop-shadow-md">
                Sistem Informasi Manajemen Perawatan & Aset
            </p>
        </div>

        <!-- Card -->
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden border border-white/30 hover-lift">
            
            <!-- Header -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-8 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-black/5 shimmer"></div>
                <div class="relative z-10">
                    <h1 class="text-2xl font-bold mb-2 tracking-tight">Selamat Datang</h1>
                    <div class="w-16 h-1 bg-white/50 mx-auto mb-3 rounded-full"></div>
                    <p class="text-orange-50 text-sm font-medium">PT Bank Negara Indonesia (Persero) Tbk</p>
                    <p class="text-orange-100/80 text-xs mt-1">Unit Logistik & Manajemen Modal Manusia</p>
                </div>
                
                <!-- Decorative corner -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            </div>

            <!-- Form -->
            <div class="p-8 lg:p-10">
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fadeInUp hover-lift">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                            </div>
                            <p class="ml-3 text-red-700 text-sm font-medium"><?= session()->getFlashdata('error') ?></p>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fadeInUp hover-lift">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            </div>
                            <p class="ml-3 text-green-700 text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="POST" class="space-y-6">
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div class="space-y-2 animate-slideInRight" style="animation-delay: 0.1s;">
                        <label for="username" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user mr-2 text-orange-500"></i>Username
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 group-focus-within:text-orange-500 transition-colors duration-200"></i>
                            </div>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                value="<?= old('username') ?>"
                                class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 input-focus-glow bg-white/80 hover:bg-white hover:border-orange-300"
                                placeholder="Masukkan username Anda"
                                required
                                autofocus
                            >
                        </div>
                        <?php if (isset($errors['username'])): ?>
                            <p class="mt-2 text-xs text-red-500 flex items-center animate-fadeInUp">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <?= $errors['username'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2 animate-slideInRight" style="animation-delay: 0.2s;">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-lock mr-2 text-orange-500"></i>Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 group-focus-within:text-orange-500 transition-colors duration-200"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full pl-12 pr-12 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 input-focus-glow bg-white/80 hover:bg-white hover:border-orange-300"
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors duration-200 focus:outline-none"
                                aria-label="Toggle password visibility"
                            >
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <p class="mt-2 text-xs text-red-500 flex items-center animate-fadeInUp">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <?= $errors['password'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-2 animate-slideInRight" style="animation-delay: 0.3s;">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 focus:ring-2 transition-all duration-200 cursor-pointer">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors duration-200">Ingat Saya</span>
                        </label>
                        <a href="<?= base_url('forgot-password') ?>" class="text-sm text-orange-600 hover:text-orange-700 font-semibold hover:underline transition-all duration-200">
                            <i class="fas fa-question-circle mr-1"></i>Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-xl font-bold text-base hover:from-orange-600 hover:to-orange-700 transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 relative overflow-hidden group animate-slideInRight"
                        style="animation-delay: 0.4s;"
                    >
                        <span class="relative z-10">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
                        </span>
                        <div class="absolute inset-0 bg-white/20 transform translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                    </button>

                </form>

                <!-- Divider -->
                <div class="relative my-8 animate-fadeInUp" style="animation-delay: 0.5s;">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">
                            <i class="fas fa-shield-alt mr-1 text-orange-500"></i>
                            Login Aman & Terenkripsi
                        </span>
                    </div>
                </div>

                <!-- System Info -->
                <div class="space-y-3 animate-fadeInUp" style="animation-delay: 0.6s;">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-4 hover-lift">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-orange-900 mb-1">Informasi Sistem</h4>
                                <p class="text-xs text-orange-700 leading-relaxed">
                                    Gunakan kredensial yang telah diberikan oleh administrator sistem. 
                                    Untuk bantuan, hubungi IT Support di ext. 1234.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-lock text-green-500"></i>
                            <span>SSL Encrypted</span>
                        </div>
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-shield-alt text-blue-500"></i>
                            <span>Protected</span>
                        </div>
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-check-circle text-orange-500"></i>
                            <span>Verified</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white space-y-2 animate-fadeInUp" style="animation-delay: 0.7s;">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-building text-orange-200"></i>
                <p class="text-sm font-medium drop-shadow-lg">
                    &copy; <?= date('Y') ?> PT Bank Negara Indonesia (Persero) Tbk
                </p>
            </div>
            <p class="text-xs text-orange-50 drop-shadow-lg">
                All Rights Reserved • Secure Login Portal v1.0
            </p>
            <div class="flex items-center justify-center space-x-3 text-xs text-orange-100 pt-2">
                <a href="#" class="hover:text-white transition-colors duration-200 hover:underline">
                    <i class="fas fa-book mr-1"></i>Panduan
                </a>
                <span>•</span>
                <a href="#" class="hover:text-white transition-colors duration-200 hover:underline">
                    <i class="fas fa-headset mr-1"></i>Support
                </a>
                <span>•</span>
                <a href="#" class="hover:text-white transition-colors duration-200 hover:underline">
                    <i class="fas fa-file-contract mr-1"></i>Privacy
                </a>
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

        // Keyboard navigation
        document.getElementById('username').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        });

        // Add loading state to submit button
        const loginForm = document.querySelector('form');
        const submitBtn = loginForm.querySelector('button[type="submit"]');
        
        loginForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-red-50, .bg-green-50');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Add ripple effect on button click
        submitBtn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    </script>

</body>
</html>