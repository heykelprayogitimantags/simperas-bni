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
    
    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.95);
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
            opacity: 0.8;
        }
    }
    
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    .animate-scale-in {
        animation: scaleIn 0.4s ease-out forwards;
    }
    
    /* Gradient Stat Cards */
    .gradient-stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .gradient-stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }
    
    .gradient-stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
    }
    
    .gradient-stat-card .icon-wrapper {
        transition: all 0.3s ease;
    }
    
    .gradient-stat-card:hover .icon-wrapper {
        transform: scale(1.15) rotate(10deg);
    }
    
    /* Alert Box Enhancement */
    .alert-box {
        position: relative;
        overflow: hidden;
        animation: slideInRight 0.5s ease-out;
    }
    
    .alert-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-orange), var(--primary-orange-light));
    }
    
    /* Ticket Card Enhancement */
    .ticket-card {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 4px solid transparent;
    }
    
    .ticket-card.priority-high {
        border-left-color: #EF4444;
        background: linear-gradient(to right, rgba(239, 68, 68, 0.05) 0%, white 100%);
    }
    
    .ticket-card.priority-medium {
        border-left-color: #F59E0B;
        background: linear-gradient(to right, rgba(245, 158, 11, 0.05) 0%, white 100%);
    }
    
    .ticket-card.priority-low {
        border-left-color: #10B981;
        background: linear-gradient(to right, rgba(16, 185, 129, 0.05) 0%, white 100%);
    }
    
    .ticket-card:hover {
        transform: translateX(8px);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.2);
    }
    
    .ticket-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(to bottom, transparent, var(--primary-orange), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .ticket-card:hover::after {
        opacity: 1;
    }
    
    /* Button Enhancements */
    .btn-action {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-action::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-action:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px -4px rgba(255, 107, 53, 0.4);
    }
    
    /* Work History Card */
    .work-card {
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
    }
    
    .work-card:hover {
        border-color: var(--primary-orange);
        box-shadow: 0 4px 12px -2px rgba(255, 107, 53, 0.15);
        transform: translateY(-2px);
    }
    
    /* Badge Enhancements */
    .status-badge {
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
    }
    
    .priority-badge {
        font-weight: 700;
        font-size: 10px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Empty State */
    .empty-state {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .empty-state .icon-wrapper {
        animation: pulse 2s ease-in-out infinite;
    }
    
    /* Stat Number Animation */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-number {
        animation: countUp 0.6s ease-out;
    }
    
    /* Section Header */
    .section-header {
        position: relative;
        padding-left: 16px;
    }
    
    .section-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: linear-gradient(to bottom, var(--primary-orange), var(--primary-orange-light));
        border-radius: 2px;
    }
    
    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--gray-100);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-orange);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .text-3xl {
            font-size: 1.875rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
    }
</style>

<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6 bg-gray-50">
    
    <!-- Welcome Section -->
    <div class="mb-8 animate-fade-in-up">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Dashboard Teknisi</h2>
        <p class="text-gray-600 mt-2 text-lg">Selamat datang, <span class="font-semibold text-orange-600"><?= esc($user['full_name']) ?></span>! 🔧</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Pending Tickets -->
        <div class="gradient-stat-card bg-gradient-to-br from-red-500 via-red-600 to-red-700 rounded-2xl shadow-2xl p-6 text-white animate-slide-in-right" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-red-100 text-sm font-semibold uppercase tracking-wide mb-1">Tiket Pending</p>
                    <h3 class="stat-number text-4xl font-bold mt-2"><?= $my_tickets['pending'] ?></h3>
                    <p class="text-red-100 text-xs mt-2 font-medium">Perlu dikerjakan</p>
                </div>
                <div class="icon-wrapper bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- In Progress -->
        <div class="gradient-stat-card bg-gradient-to-br from-yellow-500 via-yellow-600 to-amber-600 rounded-2xl shadow-2xl p-6 text-white animate-slide-in-right" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-yellow-100 text-sm font-semibold uppercase tracking-wide mb-1">Sedang Dikerjakan</p>
                    <h3 class="stat-number text-4xl font-bold mt-2"><?= $my_tickets['in_progress'] ?></h3>
                    <p class="text-yellow-100 text-xs mt-2 font-medium">In progress</p>
                </div>
                <div class="icon-wrapper bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-spinner text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Completed This Month -->
        <div class="gradient-stat-card bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 rounded-2xl shadow-2xl p-6 text-white animate-slide-in-right" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-green-100 text-sm font-semibold uppercase tracking-wide mb-1">Selesai Bulan Ini</p>
                    <h3 class="stat-number text-4xl font-bold mt-2"><?= $my_maintenance_this_month ?></h3>
                    <p class="text-green-100 text-xs mt-2 font-medium"><?= date('F Y') ?></p>
                </div>
                <div class="icon-wrapper bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Maintenance -->
        <div class="gradient-stat-card bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-2xl p-6 text-white animate-slide-in-right" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide mb-1">Total Perbaikan</p>
                    <h3 class="stat-number text-4xl font-bold mt-2"><?= $my_maintenance_count ?></h3>
                    <p class="text-blue-100 text-xs mt-2 font-medium">Semua periode</p>
                </div>
                <div class="icon-wrapper bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-tools text-3xl"></i>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Asset Alerts -->
    <div class="alert-box bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 p-6 mb-8 rounded-2xl shadow-md animate-scale-in" style="animation-delay: 0.5s;">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                <i class="fas fa-exclamation-circle text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-orange-900 text-lg mb-1">Asset Perlu Perhatian</p>
                <p class="text-sm text-orange-700 font-medium">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-bold text-xs mr-2">
                        <i class="fas fa-wrench mr-1"></i> <?= $assets_need_attention['rusak_ringan'] ?> Rusak Ringan
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 font-bold text-xs">
                        <i class="fas fa-exclamation-triangle mr-1"></i> <?= $assets_need_attention['rusak_berat'] ?> Rusak Berat
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Tiket yang Harus Dikerjakan (2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8 animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="flex items-center justify-between mb-6">
                <h3 class="section-header text-2xl font-bold text-gray-900">
                    Tiket yang Harus Dikerjakan
                </h3>
                <a href="<?= base_url('ticket') ?>" class="text-sm text-orange-600 hover:text-orange-700 font-semibold flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 transition-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($assigned_tickets)): ?>
                    <div class="empty-state text-center py-16">
                        <div class="icon-wrapper inline-block p-6 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-check-circle text-green-500 text-6xl"></i>
                        </div>
                        <p class="text-gray-600 font-semibold text-lg mb-2">Tidak ada tiket yang perlu dikerjakan saat ini</p>
                        <p class="text-sm text-gray-400">Great job! 🎉</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($assigned_tickets as $ticket): ?>
                        <div class="ticket-card priority-<?= $ticket['priority'] ?> p-6 rounded-xl hover:shadow-xl transition-all">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                                        <span class="text-xs font-mono font-bold bg-gray-900 text-white px-3 py-1.5 rounded-lg shadow-sm"><?= esc($ticket['ticket_number']) ?></span>
                                        <span class="priority-badge px-3 py-1.5 rounded-lg
                                            <?= $ticket['priority'] === 'high' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : 
                                                ($ticket['priority'] === 'medium' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white' : 'bg-gradient-to-r from-green-500 to-green-600 text-white') ?>">
                                            <?= $ticket['priority'] === 'high' ? '🔴 HIGH PRIORITY' : 
                                                ($ticket['priority'] === 'medium' ? '🟡 MEDIUM' : '🟢 LOW') ?>
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 text-lg mb-2"><?= esc($ticket['title']) ?></h4>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc(substr($ticket['description'], 0, 120)) ?>...</p>
                                </div>
                                <span class="status-badge ml-4 px-3 py-1.5 rounded-lg
                                    <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' ?>">
                                    <?= $ticket['status'] === 'pending' ? '⏳ PENDING' : '⚙️ IN PROGRESS' ?>
                                </span>
                            </div>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center gap-4 text-xs text-gray-500 font-medium flex-wrap">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-laptop text-orange-500"></i> 
                                        <span class="font-semibold text-gray-700"><?= esc($ticket['asset_name']) ?></span>
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-user text-orange-500"></i> 
                                        <?= esc($ticket['reporter_name']) ?>
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-clock text-orange-500"></i> 
                                        <?= date('d M Y', strtotime($ticket['created_at'])) ?>
                                    </span>
                                </div>
                                <a href="<?= base_url('maintenance/update/' . $ticket['ticket_id']) ?>" class="btn-action bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-5 py-2.5 rounded-lg transition-all font-bold text-sm flex items-center gap-2 shadow-lg">
                                    <i class="fas fa-wrench"></i>
                                    <span>Update</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Riwayat Pekerjaan Saya (1 column) -->
        <div class="bg-white rounded-2xl shadow-xl p-8 animate-fade-in-up" style="animation-delay: 0.7s;">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-history text-white text-lg"></i>
                    </div>
                    <span>Pekerjaan Terbaru</span>
                </h3>
            </div>
            
            <div class="space-y-3">
                <?php if (empty($my_recent_work)): ?>
                    <div class="text-center py-8">
                        <div class="inline-block p-4 bg-gray-100 rounded-full mb-3">
                            <i class="fas fa-inbox text-gray-300 text-4xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Belum ada riwayat</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($my_recent_work as $work): ?>
                        <div class="work-card bg-gradient-to-br from-gray-50 to-white p-4 rounded-xl hover:shadow-lg transition-all">
                            <p class="font-bold text-gray-900 text-sm mb-1 flex items-center gap-2">
                                <i class="fas fa-laptop text-orange-500"></i>
                                <?= esc($work['asset_name']) ?>
                            </p>
                            <p class="text-xs text-gray-600 mt-2 leading-relaxed bg-white bg-opacity-50 p-2 rounded">
                                <?= esc(substr($work['diagnosis'], 0, 60)) ?>...
                            </p>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                                <span class="text-xs text-gray-500 font-medium flex items-center gap-1.5">
                                    <i class="fas fa-calendar text-orange-500"></i>
                                    <?= date('d M Y', strtotime($work['created_at'])) ?>
                                </span>
                                <?php if ($work['cost']): ?>
                                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                                        Rp <?= number_format($work['cost'], 0, ',', '.') ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <a href="<?= base_url('maintenance/history') ?>" class="block text-center mt-6 text-sm text-orange-600 hover:text-orange-700 font-bold px-4 py-3 rounded-lg hover:bg-orange-50 transition-all">
                Lihat Semua Riwayat <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
    </div>
    
</main>

<?= view('layout/footer') ?>