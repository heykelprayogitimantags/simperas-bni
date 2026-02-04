<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simperas</title>
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

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .input-focus-glow:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
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
    </style>
</head>
<body class="bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 gradient-animate min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10 animate-fadeInUp">
        <!-- Logo Container -->
        <div class="text-center mb-8">
            <div class="inline-block animate-float">
                <div class="bg-white rounded-full p-6 shadow-2xl">
                    <i class="fas fa-tools text-6xl text-orange-500"></i>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            
            <!-- Header -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-8 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-black/5"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2 tracking-tight">SIMPERAS</h1>
                    <div class="w-16 h-1 bg-white/50 mx-auto mb-3 rounded-full"></div>
                    <p class="text-orange-50 text-sm font-medium">PT Bank Negara Indonesia (Persero) Tbk</p>
                    <p class="text-orange-100/80 text-xs mt-1">Unit Logistik & Manajemen Modal Manusia</p>
                </div>
            </div>

            <!-- Form -->
            <div class="p-8 lg:p-10">
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fadeInUp">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                            </div>
                            <p class="ml-3 text-red-700 text-sm font-medium"><?= session()->getFlashdata('error') ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fadeInUp">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            </div>
                            <p class="ml-3 text-green-700 text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="POST" class="space-y-6">
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div class="space-y-2">
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
                                class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 input-focus-glow bg-white/80"
                                placeholder="Masukkan username Anda"
                                required
                                autofocus
                            >
                        </div>
                        <?php if (isset($errors['username'])): ?>
                            <p class="mt-2 text-xs text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <?= $errors['username'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
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
                                class="w-full pl-12 pr-12 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 input-focus-glow bg-white/80"
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors duration-200 focus:outline-none"
                            >
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <p class="mt-2 text-xs text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <?= $errors['password'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 focus:ring-2 transition-all duration-200 cursor-pointer">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors duration-200">Ingat Saya</span>
                        </label>
                        <a href="#" class="text-sm text-orange-600 hover:text-orange-700 font-semibold hover:underline transition-all duration-200">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-xl font-bold text-base hover:from-orange-600 hover:to-orange-700 transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
                    </button>

                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                </div>

                

        <!-- Footer -->
        <div class="text-center mt-8 text-white">
            <p class="text-sm font-medium drop-shadow-lg">&copy; <?= date('Y') ?> PT Bank Negara Indonesia (Persero) Tbk</p>
            <p class="text-xs mt-1 text-orange-50 drop-shadow-lg">All Rights Reserved • Secure Login Portal</p>
        </div>
    </div>

    <script>
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

        // Auto-fill demo credentials on click
        document.querySelectorAll('.bg-gradient-to-br').forEach((card, index) => {
            card.addEventListener('click', function() {
                const credentials = [
                    { username: 'admin', password: 'admin123' },
                    { username: 'teknisi', password: 'teknisi123' },
                    { username: 'pegawai', password: 'pegawai123' }
                ];
                
                document.getElementById('username').value = credentials[index].username;
                document.getElementById('password').value = credentials[index].password;
                
                // Add visual feedback
                this.classList.add('ring-2', 'ring-offset-2');
                if (index === 0) this.classList.add('ring-orange-500');
                if (index === 1) this.classList.add('ring-blue-500');
                if (index === 2) this.classList.add('ring-green-500');
                
                setTimeout(() => {
                    this.classList.remove('ring-2', 'ring-offset-2', 'ring-orange-500', 'ring-blue-500', 'ring-green-500');
                }, 1000);
            });
        });

        // Add keyboard navigation
        document.getElementById('username').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        });
    </script>

</body>
</html>