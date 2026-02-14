<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap');
    
    :root {
        --primary-orange: #FF6B35;
        --primary-orange-dark: #E85A28;
        --primary-orange-light: #FF8C66;
        --accent-blue: #2B7DE9;
        --accent-green: #00D9A5;
        --accent-yellow: #FFB800;
        --accent-red: #FF4757;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-600: #4B5563;
        --gray-700: #374151;
        --gray-800: #1F2937;
        --gray-900: #111827;
    }
    
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Outfit', sans-serif;
    }
    
    /* Advanced Animations */
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
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
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
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    .animate-scale-in {
        animation: scaleIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    /* Enhanced Stat Cards */
    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .stat-card:hover::after {
        left: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .stat-card .icon-wrapper {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stat-card:hover .icon-wrapper {
        transform: scale(1.15) rotate(10deg);
    }
    
    /* Chart Container Enhancement */
    .chart-container {
        position: relative;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .chart-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-orange), var(--accent-blue));
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .chart-container:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
    }
    
    .chart-container:hover::before {
        opacity: 1;
    }
    
    /* Activity Card Enhancement */
    .activity-card {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    
    .activity-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        transition: all 0.3s;
    }
    
    .activity-card.priority-high::before {
        background: linear-gradient(to bottom, #EF4444, #DC2626);
    }
    
    .activity-card.priority-medium::before {
        background: linear-gradient(to bottom, #F59E0B, #D97706);
    }
    
    .activity-card.priority-low::before {
        background: linear-gradient(to bottom, #10B981, #059669);
    }
    
    .activity-card.maintenance::before {
        background: linear-gradient(to bottom, #3B82F6, #2563EB);
    }
    
    .activity-card:hover {
        transform: translateX(8px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.15);
    }
    
    .activity-card:hover::before {
        width: 6px;
    }
    
    /* Badge Enhancements */
    .status-badge {
        font-weight: 700;
        font-size: 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 0.375rem 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s;
    }
    
    .status-badge:hover {
        transform: scale(1.05);
    }
    
    /* Section Header with Accent */
    .section-header {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-header .icon-box {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        transition: all 0.3s;
    }
    
    .chart-container:hover .section-header .icon-box {
        transform: rotate(10deg) scale(1.1);
    }
    
    /* Empty State */
    .empty-state {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .empty-state .empty-icon {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Custom Scrollbar */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: rgba(203, 213, 225, 0.8) rgba(241, 245, 249, 0.5);
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(241, 245, 249, 0.5);
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(203, 213, 225, 0.8);
        border-radius: 10px;
        transition: background 0.2s;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: var(--primary-orange);
    }
    
    /* DateTime Display */
    .datetime-display {
        background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(43, 125, 233, 0.1) 100%);
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .datetime-display:hover {
        background: linear-gradient(135deg, rgba(255, 107, 53, 0.15) 0%, rgba(43, 125, 233, 0.15) 100%);
        transform: scale(1.02);
    }
    
    /* Link Hover Effects */
    .link-animated {
        position: relative;
        transition: all 0.3s;
    }
    
    .link-animated::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: currentColor;
        transition: width 0.3s;
    }
    
    .link-animated:hover::after {
        width: 100%;
    }
    
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Responsive Typography */
    @media (max-width: 768px) {
        .stat-card {
            will-change: transform;
        }
        
        .text-4xl {
            font-size: 2rem;
        }
        
        .text-3xl {
            font-size: 1.75rem;
        }
    }
    
    /* Performance Optimizations */
    .stat-card, .chart-container, .activity-card {
        will-change: transform;
        backface-visibility: hidden;
        perspective: 1000px;
    }
</style>

<?= view('layout/sidebar', ['user' => $user]) ?>

<main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">
    
    <!-- Container with responsive padding -->
    <div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8 max-w-7xl">
        
        <!-- Header Section -->
        <div class="mb-6 md:mb-8 animate-fade-in-up">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 tracking-tight">
                        Dashboard Admin
                    </h1>
                    <p class="text-gray-600 mt-2 text-base md:text-lg">
                        Selamat datang, <span class="font-bold text-orange-600"><?= esc($user['full_name']) ?></span> 👨‍💼
                    </p>
                </div>
                <div class="datetime-display text-xs sm:text-sm text-gray-700">
                    <i class="far fa-clock mr-2 text-orange-500"></i>
                    <span id="currentDateTime"></span>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 lg:gap-6 mb-6 md:mb-8">
            
            <!-- Total Asset Card -->
            <div class="stat-card bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-2xl shadow-2xl p-6 lg:p-7 text-white">
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-2">Total Asset</p>
                            <h3 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-none mb-2"><?= $total_assets ?></h3>
                            <p class="text-blue-100 text-xs font-medium">Hardware & Software</p>
                        </div>
                        <div class="icon-wrapper bg-white/20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                            <i class="fas fa-database text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <a href="<?= base_url('asset') ?>" class="text-xs text-white hover:text-blue-100 font-bold inline-flex items-center group">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Total Tiket Card -->
            <div class="stat-card bg-gradient-to-br from-orange-500 via-orange-600 to-red-600 rounded-2xl shadow-2xl p-6 lg:p-7 text-white">
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-orange-100 text-xs font-bold uppercase tracking-wider mb-2">Total Tiket</p>
                            <h3 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-none mb-2"><?= $total_tickets ?></h3>
                            <p class="text-orange-100 text-xs font-medium">Semua periode</p>
                        </div>
                        <div class="icon-wrapper bg-white/20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                            <i class="fas fa-ticket-alt text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <a href="<?= base_url('ticket') ?>" class="text-xs text-white hover:text-orange-100 font-bold inline-flex items-center group">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Tiket Pending Card -->
            <div class="stat-card bg-gradient-to-br from-red-500 via-rose-600 to-pink-700 rounded-2xl shadow-2xl p-6 lg:p-7 text-white">
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-red-100 text-xs font-bold uppercase tracking-wider mb-2">Tiket Pending</p>
                            <h3 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-none mb-2"><?= $ticket_by_status['pending'] ?></h3>
                            <p class="text-red-100 text-xs font-medium">Perlu ditindaklanjuti</p>
                        </div>
                        <div class="icon-wrapper bg-white/20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                            <i class="fas fa-exclamation-circle text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <a href="<?= base_url('ticket?status=pending') ?>" class="text-xs text-white hover:text-red-100 font-bold inline-flex items-center group">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Maintenance Card -->
            <div class="stat-card bg-gradient-to-br from-emerald-500 via-green-600 to-teal-700 rounded-2xl shadow-2xl p-6 lg:p-7 text-white">
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-emerald-100 text-xs font-bold uppercase tracking-wider mb-2">Maintenance</p>
                            <h3 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-none mb-2"><?= $maintenance_this_month ?></h3>
                            <p class="text-emerald-100 text-xs font-medium"><?= date('F Y') ?></p>
                        </div>
                        <div class="icon-wrapper bg-white/20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                            <i class="fas fa-wrench text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <a href="<?= base_url('maintenance') ?>" class="text-xs text-white hover:text-emerald-100 font-bold inline-flex items-center group">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-6 mb-6 md:mb-8">
            
            <!-- Asset Status Chart -->
            <div class="chart-container animate-scale-in" style="animation-delay: 0.5s;">
                <div class="p-6 lg:p-7 border-b border-gray-100">
                    <h3 class="section-header text-lg lg:text-xl font-bold text-gray-900">
                        <div class="icon-box bg-gradient-to-br from-blue-100 to-blue-200">
                            <i class="fas fa-chart-pie text-blue-600"></i>
                        </div>
                        <span>Status Asset</span>
                    </h3>
                </div>
                <div class="p-6 lg:p-7">
                    <div class="relative" style="height: 300px;">
                        <canvas id="assetStatusChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Ticket Priority Chart -->
            <div class="chart-container animate-scale-in" style="animation-delay: 0.6s;">
                <div class="p-6 lg:p-7 border-b border-gray-100">
                    <h3 class="section-header text-lg lg:text-xl font-bold text-gray-900">
                        <div class="icon-box bg-gradient-to-br from-orange-100 to-orange-200">
                            <i class="fas fa-chart-bar text-orange-600"></i>
                        </div>
                        <span>Prioritas Tiket</span>
                    </h3>
                </div>
                <div class="p-6 lg:p-7">
                    <div class="relative" style="height: 300px;">
                        <canvas id="ticketPriorityChart"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Recent Activities Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-6">
            
            <!-- Recent Tickets -->
            <div class="chart-container animate-scale-in" style="animation-delay: 0.7s;">
                <div class="p-6 lg:p-7 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="section-header text-lg lg:text-xl font-bold text-gray-900">
                            <div class="icon-box bg-gradient-to-br from-orange-100 to-orange-200">
                                <i class="fas fa-ticket-alt text-orange-600"></i>
                            </div>
                            <span>Tiket Terbaru</span>
                        </h3>
                        <a href="<?= base_url('ticket') ?>" class="link-animated text-sm text-orange-600 hover:text-orange-700 font-bold inline-flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 transition-all">
                            Lihat Semua 
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-6 lg:p-7">
                    <div class="space-y-4 max-h-[450px] overflow-y-auto custom-scrollbar">
                        <?php if (empty($recent_tickets)): ?>
                            <div class="empty-state text-center py-16">
                                <div class="empty-icon inline-block p-6 bg-gray-100 rounded-full mb-4">
                                    <i class="fas fa-inbox text-gray-300 text-5xl"></i>
                                </div>
                                <p class="text-gray-600 font-bold text-lg mb-2">Belum ada tiket</p>
                                <p class="text-gray-400 text-sm">Tiket akan muncul di sini</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_tickets as $ticket): ?>
                                <div class="activity-card priority-<?= $ticket['priority'] ?> bg-gradient-to-r from-<?= $ticket['priority'] === 'high' ? 'red' : ($ticket['priority'] === 'medium' ? 'amber' : 'green') ?>-50/50 to-white rounded-xl p-5 border border-gray-200">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <h4 class="font-bold text-gray-900 text-sm md:text-base flex-1 line-clamp-2 hover:text-orange-600 transition-colors">
                                                <?= esc($ticket['title']) ?>
                                            </h4>
                                            <span class="status-badge flex-shrink-0
                                                <?= $ticket['status'] === 'pending' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : 
                                                    ($ticket['status'] === 'in_progress' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white' : 'bg-gradient-to-r from-green-500 to-green-600 text-white') ?>">
                                                <?= $ticket['status'] === 'pending' ? '⏳ PENDING' : 
                                                    ($ticket['status'] === 'in_progress' ? '⚙️ PROGRESS' : '✅ DONE') ?>
                                            </span>
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-gray-600 font-medium">
                                            <div class="inline-flex items-center gap-1.5">
                                                <i class="fas fa-laptop text-orange-500"></i>
                                                <span class="truncate max-w-[150px] sm:max-w-none font-semibold text-gray-700"><?= esc($ticket['asset_name']) ?></span>
                                            </div>
                                            <div class="inline-flex items-center gap-1.5">
                                                <i class="fas fa-user text-orange-500"></i>
                                                <span class="truncate max-w-[150px] sm:max-w-none"><?= esc($ticket['reporter_name']) ?></span>
                                            </div>
                                            <div class="inline-flex items-center gap-1.5">
                                                <i class="far fa-clock text-orange-500"></i>
                                                <span><?= date('d M Y', strtotime($ticket['created_at'])) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Recent Maintenance -->
            <div class="chart-container animate-scale-in" style="animation-delay: 0.8s;">
                <div class="p-6 lg:p-7 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="section-header text-lg lg:text-xl font-bold text-gray-900">
                            <div class="icon-box bg-gradient-to-br from-blue-100 to-blue-200">
                                <i class="fas fa-wrench text-blue-600"></i>
                            </div>
                            <span>Maintenance Terbaru</span>
                        </h3>
                        <a href="<?= base_url('maintenance') ?>" class="link-animated text-sm text-blue-600 hover:text-blue-700 font-bold inline-flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-blue-50 transition-all">
                            Lihat Semua 
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-6 lg:p-7">
                    <div class="space-y-4 max-h-[450px] overflow-y-auto custom-scrollbar">
                        <?php if (empty($recent_maintenance)): ?>
                            <div class="empty-state text-center py-16">
                                <div class="empty-icon inline-block p-6 bg-gray-100 rounded-full mb-4">
                                    <i class="fas fa-tools text-gray-300 text-5xl"></i>
                                </div>
                                <p class="text-gray-600 font-bold text-lg mb-2">Belum ada maintenance</p>
                                <p class="text-gray-400 text-sm">Riwayat maintenance akan muncul di sini</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_maintenance as $log): ?>
                                <div class="activity-card maintenance bg-gradient-to-r from-blue-50/50 to-white rounded-xl p-5 border border-gray-200">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <h4 class="font-bold text-gray-900 text-sm md:text-base flex-1 hover:text-blue-600 transition-colors">
                                                <?= esc($log['asset_name']) ?>
                                            </h4>
                                            <span class="text-xs text-gray-500 font-semibold whitespace-nowrap bg-gray-100 px-3 py-1.5 rounded-lg">
                                                <?= date('d M Y', strtotime($log['created_at'])) ?>
                                            </span>
                                        </div>
                                        
                                        <p class="text-xs md:text-sm text-gray-700 line-clamp-2 leading-relaxed bg-white bg-opacity-70 p-3 rounded-lg border border-gray-100">
                                            <?= esc($log['diagnosis']) ?>
                                        </p>
                                        
                                        <div class="flex items-center">
                                            <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-full px-4 py-2 inline-flex items-center gap-2">
                                                <i class="fas fa-user-cog text-blue-600"></i>
                                                <span class="text-xs font-bold text-blue-900 truncate max-w-[180px] sm:max-w-none"><?= esc($log['technician_name']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
</main>

<!-- Chart.js Scripts -->
<script>
// Update current date time
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
}
updateDateTime();
setInterval(updateDateTime, 60000);

// Chart.js Configuration
Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";

// Asset Status Chart
const assetCtx = document.getElementById('assetStatusChart').getContext('2d');
const assetChart = new Chart(assetCtx, {
    type: 'doughnut',
    data: {
        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
        datasets: [{
            data: [
                <?= $asset_by_status['baik'] ?>,
                <?= $asset_by_status['rusak_ringan'] ?>,
                <?= $asset_by_status['rusak_berat'] ?>
            ],
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#ef4444'
            ],
            borderWidth: 4,
            borderColor: '#ffffff',
            hoverOffset: 15,
            hoverBorderWidth: 5,
            hoverBorderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: window.innerWidth < 640 ? 'bottom' : 'right',
                labels: {
                    padding: window.innerWidth < 640 ? 15 : 25,
                    font: {
                        size: window.innerWidth < 640 ? 12 : 14,
                        weight: '600',
                        family: "'Inter', sans-serif"
                    },
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: 12,
                    boxHeight: 12
                }
            },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                padding: 16,
                cornerRadius: 12,
                titleFont: {
                    size: 15,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 14,
                    weight: '500'
                },
                displayColors: true,
                boxWidth: 12,
                boxHeight: 12,
                boxPadding: 8,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.parsed || 0;
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return ' ' + label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '68%',
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 1200,
            easing: 'easeInOutQuart'
        }
    }
});

// Ticket Priority Chart
const ticketCtx = document.getElementById('ticketPriorityChart').getContext('2d');
const ticketChart = new Chart(ticketCtx, {
    type: 'bar',
    data: {
        labels: ['Low', 'Medium', 'High'],
        datasets: [{
            label: 'Jumlah Tiket',
            data: [
                <?= $ticket_by_priority['low'] ?>,
                <?= $ticket_by_priority['medium'] ?>,
                <?= $ticket_by_priority['high'] ?>
            ],
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#ef4444'
            ],
            borderRadius: 10,
            borderWidth: 0,
            hoverBackgroundColor: [
                '#059669',
                '#d97706',
                '#dc2626'
            ],
            barPercentage: 0.7,
            categoryPercentage: 0.8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: {
                        size: window.innerWidth < 640 ? 12 : 14,
                        weight: '600',
                        family: "'Inter', sans-serif"
                    },
                    color: '#6b7280',
                    padding: 10
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.06)',
                    drawBorder: false,
                    lineWidth: 1
                },
                border: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    font: {
                        size: window.innerWidth < 640 ? 12 : 14,
                        weight: '700',
                        family: "'Inter', sans-serif"
                    },
                    color: '#374151',
                    padding: 10
                },
                border: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                padding: 16,
                cornerRadius: 12,
                titleFont: {
                    size: 15,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 14,
                    weight: '600'
                },
                displayColors: false,
                callbacks: {
                    title: function(context) {
                        return 'Prioritas: ' + context[0].label;
                    },
                    label: function(context) {
                        return 'Total: ' + context.parsed.y + ' tiket';
                    }
                }
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeInOutQuart'
        }
    }
});

// Handle window resize
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        const isMobile = window.innerWidth < 640;
        
        assetChart.options.plugins.legend.position = isMobile ? 'bottom' : 'right';
        assetChart.options.plugins.legend.labels.padding = isMobile ? 15 : 25;
        assetChart.options.plugins.legend.labels.font.size = isMobile ? 12 : 14;
        
        ticketChart.options.scales.y.ticks.font.size = isMobile ? 12 : 14;
        ticketChart.options.scales.x.ticks.font.size = isMobile ? 12 : 14;
        
        assetChart.update();
        ticketChart.update();
    }, 250);
});
</script>

<?= view('layout/footer') ?>