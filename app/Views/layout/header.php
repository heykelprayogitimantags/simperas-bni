<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Manajemen Perawatan Hardware & Software PT Bank Negara Indonesia">
    <meta name="author" content="PT Bank Negara Indonesia">
    <title><?= $title ?? 'Dashboard' ?> - Sistem Manajemen Perawatan BNI</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico') ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        [x-cloak] { 
            display: none !important; 
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
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
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    <!-- Top Navbar - BNI Orange Theme -->
    <nav class="bg-gradient-to-r from-orange-500 via-orange-600 to-orange-500 shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-18">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3 md:space-x-4">
                    <!-- Mobile Menu Toggle -->
                    <button 
                        @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden text-white hover:bg-orange-600 p-2 rounded-lg transition-colors"
                        aria-label="Toggle Menu">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="bg-white rounded-lg p-2 shadow-lg">
                            <i class="fas fa-toolbox text-orange-500 text-xl md:text-2xl"></i>
                        </div>
                        <div class="ml-3 hidden sm:block">
                            <h1 class="text-white font-bold text-base md:text-lg leading-tight">
                                Sistem Manajemen Perawatan
                            </h1>
                            <p class="text-orange-100 text-xs flex items-center">
                                <i class="fas fa-building text-white mr-1"></i>
                                PT Bank Negara Indonesia
                            </p>
                        </div>
                        <!-- Mobile Logo -->
                        <div class="ml-2 sm:hidden">
                            <h1 class="text-white font-bold text-sm">BNI IT Support</h1>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side Menu -->
                <div class="flex items-center space-x-2 md:space-x-4">
                    
                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open"
                            class="relative text-white hover:bg-orange-600 p-2 md:p-2.5 rounded-lg transition-colors"
                            aria-label="Notifications">
                            <i class="fas fa-bell text-lg md:text-xl"></i>
                            <!-- Notification Badge -->
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-orange-600">
                                3
                            </span>
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden">
                            
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3">
                                <h3 class="text-white font-semibold flex items-center justify-between">
                                    <span>Notifikasi</span>
                                    <span class="bg-white/20 px-2 py-0.5 rounded-full text-xs">3 Baru</span>
                                </h3>
                            </div>
                            
                            <!-- Notifications List -->
                            <div class="max-h-96 overflow-y-auto">
                                <a href="#" class="block px-4 py-3 hover:bg-orange-50 border-b border-gray-100 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-red-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-exclamation-circle text-red-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Tiket Pending Baru</p>
                                            <p class="text-xs text-gray-600 mt-1">Ada 2 tiket yang perlu ditindaklanjuti</p>
                                            <p class="text-xs text-gray-400 mt-1">5 menit lalu</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="#" class="block px-4 py-3 hover:bg-orange-50 border-b border-gray-100 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-green-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-check-circle text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Maintenance Selesai</p>
                                            <p class="text-xs text-gray-600 mt-1">Laptop-001 telah selesai diperbaiki</p>
                                            <p class="text-xs text-gray-400 mt-1">1 jam lalu</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="#" class="block px-4 py-3 hover:bg-orange-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-orange-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-info-circle text-orange-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Update Sistem</p>
                                            <p class="text-xs text-gray-600 mt-1">Fitur baru telah ditambahkan</p>
                                            <p class="text-xs text-gray-400 mt-1">2 jam lalu</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Footer -->
                            <div class="bg-gray-50 px-4 py-2 text-center border-t border-gray-200">
                                <a href="#" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                                    Lihat Semua Notifikasi
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            class="flex items-center text-white hover:bg-orange-600 px-2 md:px-3 py-2 rounded-lg transition-colors group">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <span class="text-orange-500 font-bold text-sm md:text-base">
                                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                </span>
                            </div>
                            <div class="text-left ml-2 md:ml-3 hidden md:block">
                                <p class="text-sm font-semibold leading-tight"><?= esc($user['full_name']) ?></p>
                                <p class="text-xs text-orange-100">
                                    <i class="fas fa-circle text-green-400 text-[6px] mr-1"></i>
                                    <?= ucfirst($user['role']) ?>
                                </p>
                            </div>
                            <i class="fas fa-chevron-down text-xs ml-2 hidden md:block"></i>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden">
                            
                            <!-- User Info Header -->
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-orange-500 font-bold text-lg">
                                            <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-white font-semibold text-sm"><?= esc($user['full_name']) ?></p>
                                        <p class="text-orange-100 text-xs"><?= esc($user['email'] ?? 'user@bni.co.id') ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="<?= base_url('profile') ?>" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-orange-50 transition-colors">
                                    <div class="bg-orange-100 rounded-lg p-2 mr-3">
                                        <i class="fas fa-user-circle text-orange-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">Profil Saya</span>
                                </a>
                                
                                <a href="<?= base_url('settings') ?>" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-orange-50 transition-colors">
                                    <div class="bg-gray-100 rounded-lg p-2 mr-3">
                                        <i class="fas fa-cog text-gray-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">Pengaturan</span>
                                </a>
                                
                                <a href="<?= base_url('help') ?>" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-orange-50 transition-colors">
                                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                                        <i class="fas fa-question-circle text-green-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">Bantuan</span>
                                </a>
                            </div>
                            
                            <!-- Logout -->
                            <div class="border-t border-gray-200">
                                <a href="<?= base_url('logout') ?>" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="bg-red-100 rounded-lg p-2 mr-3">
                                        <i class="fas fa-sign-out-alt text-red-600"></i>
                                    </div>
                                    <span class="font-semibold text-sm">Keluar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </nav>
    
    <!-- Main Content Wrapper -->
    <div class="flex flex-1" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">