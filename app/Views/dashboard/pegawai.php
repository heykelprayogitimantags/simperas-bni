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
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Outfit', sans-serif;
    }
    
    /* Smooth Page Entry Animation */
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
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    .animate-scale-in {
        animation: scaleIn 0.4s ease-out forwards;
    }
    
    /* Enhanced Card Styles */
    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }
    
    .stat-card:hover::before {
        opacity: 1;
    }
    
    /* Gradient Banner Enhancement */
    .hero-banner {
        background: linear-gradient(135deg, #FF6B35 0%, #FF8C66 50%, #FFB896 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
        animation-delay: 1s;
    }
    
    /* Button Enhancements */
    .btn-primary {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-primary::before {
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
    
    .btn-primary:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -10px rgba(255, 107, 53, 0.5);
    }
    
    /* Ticket Card Enhancements */
    .ticket-card {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        border: 1px solid var(--gray-200);
    }
    
    .ticket-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--primary-orange);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .ticket-card:hover {
        border-color: var(--primary-orange);
        box-shadow: 0 8px 16px -4px rgba(255, 107, 53, 0.15);
        transform: translateX(4px);
    }
    
    .ticket-card:hover::before {
        transform: scaleY(1);
    }
    
    /* Status Badge Glow Effect */
    .status-badge {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .status-badge.status-pending {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #991B1B;
    }
    
    .status-badge.status-progress {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #92400E;
    }
    
    .status-badge.status-completed {
        background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
        color: #065F46;
    }
    
    /* Priority Badge */
    .priority-badge {
        font-weight: 600;
        font-size: 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    
    /* Info Card Styles */
    .info-card {
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    /* Step Number Enhancement */
    .step-number {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
        box-shadow: 0 4px 8px -2px rgba(255, 107, 53, 0.3);
        transition: all 0.3s ease;
    }
    
    .step-item:hover .step-number {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Empty State Enhancement */
    .empty-state {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .empty-state i {
        animation: pulse 2s ease-in-out infinite;
    }
    
    /* Icon Badge Enhancements */
    .icon-badge {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .icon-badge {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Responsive Typography */
    @media (max-width: 768px) {
        .text-3xl {
            font-size: 1.875rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
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
    
    /* Loading Skeleton (future enhancement) */
    .skeleton {
        background: linear-gradient(90deg, var(--gray-200) 25%, var(--gray-100) 50%, var(--gray-200) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s ease-in-out infinite;
    }
    
    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
</style>

<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6 bg-gray-50">
    
    <!-- Welcome Section -->
    <div class="mb-8 animate-fade-in-up">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Dashboard Pegawai</h2>
        <p class="text-gray-600 mt-2 text-lg">Selamat datang, <span class="font-semibold text-orange-600"><?= esc($user['full_name']) ?></span>! 👋</p>
    </div>
    
    <!-- Quick Action Banner -->
    <div class="hero-banner rounded-2xl shadow-2xl p-8 mb-8 text-white animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex items-center justify-between relative z-10">
            <div class="flex-1">
                <h3 class="text-3xl font-bold mb-3 tracking-tight">Ada Masalah dengan Asset Anda?</h3>
                <p class="text-orange-50 text-lg font-medium">Laporkan kerusakan dan kami akan segera menindaklanjuti</p>
            </div>
            <a href="<?= base_url('ticket/create') ?>" class="btn-primary bg-white text-orange-600 hover:bg-orange-50 px-8 py-4 rounded-xl font-bold transition-all shadow-xl text-lg flex items-center gap-3">
                <i class="fas fa-plus-circle text-xl"></i>
                <span>Lapor Kerusakan</span>
            </a>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total My Tickets -->
        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 animate-slide-in-right" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide mb-1">Total Tiket Saya</p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-2"><?= $my_tickets['total'] ?></h3>
                    <p class="text-xs text-gray-400 mt-2">Semua status</p>
                </div>
                <div class="icon-badge bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Tickets -->
        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 animate-slide-in-right" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide mb-1">Pending</p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-2"><?= $my_tickets['pending'] ?></h3>
                    <p class="text-xs text-gray-400 mt-2">Menunggu</p>
                </div>
                <div class="icon-badge bg-gradient-to-br from-red-400 to-red-600 rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-clock text-white text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- In Progress -->
        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 animate-slide-in-right" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide mb-1">In Progress</p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-2"><?= $my_tickets['in_progress'] ?></h3>
                    <p class="text-xs text-gray-400 mt-2">Sedang dikerjakan</p>
                </div>
                <div class="icon-badge bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-spinner text-white text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Completed -->
        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 animate-slide-in-right" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide mb-1">Selesai</p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-2"><?= $my_tickets['completed'] ?></h3>
                    <p class="text-xs text-gray-400 mt-2">Terselesaikan</p>
                </div>
                <div class="icon-badge bg-gradient-to-br from-green-400 to-green-600 rounded-2xl p-4 shadow-lg">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- My Recent Tickets (2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8 animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-1 h-8 bg-gradient-to-b from-orange-500 to-orange-600 rounded-full"></div>
                    <span>Tiket Saya</span>
                </h3>
                <a href="<?= base_url('ticket/my-tickets') ?>" class="text-sm text-orange-600 hover:text-orange-700 font-semibold flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 transition-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <?php if (empty($my_recent_tickets)): ?>
                <div class="empty-state text-center py-16">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-inbox text-gray-300 text-6xl"></i>
                    </div>
                    <p class="text-gray-600 font-semibold text-lg mb-2">Belum ada tiket</p>
                    <p class="text-sm text-gray-400">Klik tombol "Lapor Kerusakan" untuk membuat laporan</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($my_recent_tickets as $ticket): ?>
                        <div class="ticket-card rounded-xl p-6 hover:shadow-xl transition-all">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                                        <span class="text-xs font-mono font-bold bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg"><?= esc($ticket['ticket_number']) ?></span>
                                        <span class="status-badge text-xs px-3 py-1.5 rounded-lg font-bold
                                            <?= $ticket['status'] === 'pending' ? 'status-pending' : 
                                                ($ticket['status'] === 'in_progress' ? 'status-progress' : 'status-completed') ?>">
                                            <?= $ticket['status'] === 'pending' ? '⏳ Menunggu' : 
                                                ($ticket['status'] === 'in_progress' ? '⚙️ Dikerjakan' : '✅ Selesai') ?>
                                        </span>
                                        <span class="priority-badge text-xs px-3 py-1.5 rounded-lg
                                            <?= $ticket['priority'] === 'high' ? 'bg-red-100 text-red-700' : 
                                                ($ticket['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                            <?= $ticket['priority'] === 'high' ? '🔴 HIGH' : 
                                                ($ticket['priority'] === 'medium' ? '🟡 MEDIUM' : '🟢 LOW') ?>
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 text-lg mb-2"><?= esc($ticket['title']) ?></h4>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc(substr($ticket['description'], 0, 120)) ?>...</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-4 text-xs text-gray-500 font-medium">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-laptop text-orange-500"></i> 
                                        <?= esc($ticket['asset_name']) ?>
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-calendar text-orange-500"></i> 
                                        <?= date('d M Y', strtotime($ticket['created_at'])) ?>
                                    </span>
                                </div>
                                <a href="<?= base_url('ticket/detail/' . $ticket['ticket_id']) ?>" class="text-sm text-orange-600 hover:text-orange-700 font-bold flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 transition-all">
                                    <span>Detail</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Quick Info (1 column) -->
        <div class="space-y-6">
            
            <!-- How to Report -->
            <div class="info-card bg-white rounded-2xl shadow-xl p-7 animate-fade-in-up" style="animation-delay: 0.6s;">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-question-circle text-white text-lg"></i>
                    </div>
                    <span>Cara Melaporkan</span>
                </h3>
                <ol class="space-y-4 text-sm text-gray-700">
                    <li class="flex step-item">
                        <span class="step-number flex-shrink-0 w-7 h-7 text-white rounded-lg flex items-center justify-center mr-3 text-xs font-bold">1</span>
                        <span class="leading-relaxed">Klik tombol <strong class="text-orange-600">"Lapor Kerusakan"</strong></span>
                    </li>
                    <li class="flex step-item">
                        <span class="step-number flex-shrink-0 w-7 h-7 text-white rounded-lg flex items-center justify-center mr-3 text-xs font-bold">2</span>
                        <span class="leading-relaxed">Pilih asset yang bermasalah</span>
                    </li>
                    <li class="flex step-item">
                        <span class="step-number flex-shrink-0 w-7 h-7 text-white rounded-lg flex items-center justify-center mr-3 text-xs font-bold">3</span>
                        <span class="leading-relaxed">Jelaskan masalah secara detail</span>
                    </li>
                    <li class="flex step-item">
                        <span class="step-number flex-shrink-0 w-7 h-7 text-white rounded-lg flex items-center justify-center mr-3 text-xs font-bold">4</span>
                        <span class="leading-relaxed">Tentukan tingkat prioritas</span>
                    </li>
                    <li class="flex step-item">
                        <span class="step-number flex-shrink-0 w-7 h-7 text-white rounded-lg flex items-center justify-center mr-3 text-xs font-bold">5</span>
                        <span class="leading-relaxed">Submit dan tunggu teknisi menindaklanjuti</span>
                    </li>
                </ol>
            </div>
            
            <!-- Need Help -->
            <div class="info-card bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-7 border-2 border-green-200 animate-fade-in-up" style="animation-delay: 0.7s;">
                <h3 class="text-xl font-bold text-green-900 mb-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-life-ring text-white text-lg"></i>
                    </div>
                    <span>Butuh Bantuan?</span>
                </h3>
                <p class="text-sm text-green-700 mb-5 font-medium leading-relaxed">
                    Hubungi tim IT untuk bantuan lebih lanjut
                </p>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center text-green-800 bg-white bg-opacity-60 p-3 rounded-lg">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-phone text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-600 font-semibold">Extension</p>
                            <p class="font-bold">1234</p>
                        </div>
                    </div>
                    <div class="flex items-center text-green-800 bg-white bg-opacity-60 p-3 rounded-lg">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-600 font-semibold">Email</p>
                            <p class="font-bold text-xs">it-support@bni.co.id</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
</main>

<?= view('layout/footer') ?>