<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Welcome Section -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard Pegawai</h2>
        <p class="text-gray-600 mt-1">Selamat datang, <?= esc($user['full_name']) ?>!</p>
    </div>
    
    <!-- Quick Action Banner -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-2">Ada Masalah dengan Asset Anda?</h3>
                <p class="text-orange-100">Laporkan kerusakan dan kami akan segera menindaklanjuti</p>
            </div>
            <a href="<?= base_url('ticket/create') ?>" class="bg-white text-orange-500 hover:bg-orange-50 px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Lapor Kerusakan
            </a>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Total My Tickets -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Tiket Saya</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $my_tickets['total'] ?></h3>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-ticket-alt text-blue-500 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Tickets -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $my_tickets['pending'] ?></h3>
                </div>
                <div class="bg-red-100 rounded-full p-4">
                    <i class="fas fa-clock text-red-500 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <!-- In Progress -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">In Progress</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $my_tickets['in_progress'] ?></h3>
                </div>
                <div class="bg-yellow-100 rounded-full p-4">
                    <i class="fas fa-spinner text-yellow-500 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Completed -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Selesai</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $my_tickets['completed'] ?></h3>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- My Recent Tickets (2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-list text-blue-500 mr-2"></i>
                    Tiket Saya
                </h3>
                <a href="<?= base_url('ticket/my-tickets') ?>" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <?php if (empty($my_recent_tickets)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 font-medium">Belum ada tiket</p>
                    <p class="text-sm text-gray-400 mt-1">Klik tombol di atas untuk membuat laporan kerusakan</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($my_recent_tickets as $ticket): ?>
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded"><?= esc($ticket['ticket_number']) ?></span>
                                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                                            <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-700' : 
                                                ($ticket['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                            <?= $ticket['status'] === 'pending' ? 'Menunggu' : 
                                                ($ticket['status'] === 'in_progress' ? 'Dikerjakan' : 'Selesai') ?>
                                        </span>
                                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                                            <?= $ticket['priority'] === 'high' ? 'bg-red-200 text-red-700' : 
                                                ($ticket['priority'] === 'medium' ? 'bg-yellow-200 text-yellow-700' : 'bg-green-200 text-green-700') ?>">
                                            Priority: <?= strtoupper($ticket['priority']) ?>
                                        </span>
                                    </div>
                                    <h4 class="font-semibold text-gray-800"><?= esc($ticket['title']) ?></h4>
                                    <p class="text-sm text-gray-600 mt-1"><?= esc(substr($ticket['description'], 0, 100)) ?>...</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span><i class="fas fa-laptop mr-1"></i> <?= esc($ticket['asset_name']) ?></span>
                                    <span><i class="fas fa-calendar mr-1"></i> <?= date('d M Y', strtotime($ticket['created_at'])) ?></span>
                                </div>
                                <a href="<?= base_url('ticket/detail/' . $ticket['ticket_id']) ?>" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                                    Detail <i class="fas fa-arrow-right ml-1"></i>
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
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-question-circle text-orange-500 mr-2"></i>
                    Cara Melaporkan Kerusakan
                </h3>
                <ol class="space-y-3 text-sm text-gray-600">
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center mr-3 text-xs font-bold">1</span>
                        <span>Klik tombol <strong>"Lapor Kerusakan"</strong></span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center mr-3 text-xs font-bold">2</span>
                        <span>Pilih asset yang bermasalah</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center mr-3 text-xs font-bold">3</span>
                        <span>Jelaskan masalah secara detail</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center mr-3 text-xs font-bold">4</span>
                        <span>Tentukan tingkat prioritas</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center mr-3 text-xs font-bold">5</span>
                        <span>Submit dan tunggu teknisi menindaklanjuti</span>
                    </li>
                </ol>
            </div>
            
            <!-- Asset Info -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Asset
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-blue-700">Total Asset:</span>
                        <span class="font-semibold text-blue-900"><?= $total_assets ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Asset Tersedia:</span>
                        <span class="font-semibold text-blue-900"><?= $assets_available ?></span>
                    </div>
                </div>
                <a href="<?= base_url('asset') ?>" class="block mt-4 text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">
                    <i class="fas fa-database mr-2"></i>
                    Lihat Semua Asset
                </a>
            </div>
            
            <!-- Need Help -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                <h3 class="text-lg font-semibold text-green-900 mb-2">
                    <i class="fas fa-life-ring mr-2"></i>
                    Butuh Bantuan?
                </h3>
                <p class="text-sm text-green-700 mb-3">
                    Hubungi tim IT untuk bantuan lebih lanjut
                </p>
                <div class="space-y-2 text-sm">
                    <p class="flex items-center text-green-800">
                        <i class="fas fa-phone mr-2"></i>
                        <span>Ext: 1234</span>
                    </p>
                    <p class="flex items-center text-green-800">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>it-support@bni.co.id</span>
                    </p>
                </div>
            </div>
            
        </div>
        
    </div>
    
</main>

<?= view('layout/footer') ?>