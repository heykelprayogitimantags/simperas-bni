<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Sistem Manajemen Perawatan BNI</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js (for dashboard charts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js (for interactive components) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <i class="fas fa-tools text-white text-2xl mr-3"></i>
                    <div>
                        <h1 class="text-white font-bold text-lg">Sistem Manajemen Perawatan</h1>
                        <p class="text-orange-100 text-xs">PT Bank Negara Indonesia</p>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" class="flex items-center text-white hover:bg-orange-600 px-4 py-2 rounded-lg transition-colors">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user text-orange-500"></i>
                            </div>
                            <div class="text-left mr-2">
                                <p class="text-sm font-semibold"><?= esc($user['full_name']) ?></p>
                                <p class="text-xs text-orange-100"><?= ucfirst($user['role']) ?></p>
                            </div>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        
                        <!-- Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2">
                            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 transition-colors">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>
                            <hr class="my-2">
                            <a href="<?= base_url('logout') ?>" class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </nav>
    
    <!-- Main Content Wrapper -->
    <div class="flex">