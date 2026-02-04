<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Welcome Section -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard Teknisi</h2>
        <p class="text-gray-600 mt-1">Selamat datang, <?= esc($user['full_name']) ?>!</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Pending Tickets -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Tiket Pending</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $my_tickets['pending'] ?></h3>
                    <p class="text-red-100 text-xs mt-1">Perlu dikerjakan</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- In Progress -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Sedang Dikerjakan</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $my_tickets['in_progress'] ?></h3>
                    <p class="text-yellow-100 text-xs mt-1">In progress</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-spinner text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Completed This Month -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Selesai Bulan Ini</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $my_maintenance_this_month ?></h3>
                    <p class="text-green-100 text-xs mt-1"><?= date('F Y') ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Maintenance -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Perbaikan</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $my_maintenance_count ?></h3>
                    <p class="text-blue-100 text-xs mt-1">Semua periode</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-tools text-3xl"></i>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Asset Alerts -->
    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-orange-500 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold text-orange-800">Asset Perlu Perhatian</p>
                <p class="text-sm text-orange-700">
                    <span class="font-medium"><?= $assets_need_attention['rusak_ringan'] ?></span> asset rusak ringan, 
                    <span class="font-medium"><?= $assets_need_attention['rusak_berat'] ?></span> asset rusak berat
                </p>
            </div>
        </div>
    </div>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Tiket yang Harus Dikerjakan (2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-clipboard-list text-orange-500 mr-2"></i>
                    Tiket yang Harus Dikerjakan
                </h3>
                <a href="<?= base_url('ticket') ?>" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-3">
                <?php if (empty($assigned_tickets)): ?>
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-green-500 text-5xl mb-3"></i>
                        <p class="text-gray-500">Tidak ada tiket yang perlu dikerjakan saat ini</p>
                        <p class="text-sm text-gray-400 mt-1">Great job! 🎉</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($assigned_tickets as $ticket): ?>
                        <div class="border-l-4 <?= $ticket['priority'] === 'high' ? 'border-red-500 bg-red-50' : ($ticket['priority'] === 'medium' ? 'border-yellow-500 bg-yellow-50' : 'border-green-500 bg-green-50') ?> p-4 rounded-r hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-mono bg-gray-200 px-2 py-1 rounded"><?= esc($ticket['ticket_number']) ?></span>
                                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                                            <?= $ticket['priority'] === 'high' ? 'bg-red-200 text-red-700' : 
                                                ($ticket['priority'] === 'medium' ? 'bg-yellow-200 text-yellow-700' : 'bg-green-200 text-green-700') ?>">
                                            <?= strtoupper($ticket['priority']) ?>
                                        </span>
                                    </div>
                                    <h4 class="font-semibold text-gray-800"><?= esc($ticket['title']) ?></h4>
                                    <p class="text-sm text-gray-600 mt-1"><?= esc(substr($ticket['description'], 0, 100)) ?>...</p>
                                </div>
                                <span class="ml-4 px-3 py-1 text-xs font-semibold rounded-full
                                    <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                                </span>
                            </div>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span><i class="fas fa-laptop mr-1"></i> <?= esc($ticket['asset_name']) ?></span>
                                    <span><i class="fas fa-user mr-1"></i> <?= esc($ticket['reporter_name']) ?></span>
                                    <span><i class="fas fa-clock mr-1"></i> <?= date('d M Y', strtotime($ticket['created_at'])) ?></span>
                                </div>
                                <a href="<?= base_url('maintenance/update/' . $ticket['ticket_id']) ?>" class="text-sm bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-wrench mr-1"></i> Update
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Riwayat Pekerjaan Saya (1 column) -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-history text-blue-500 mr-2"></i>
                    Pekerjaan Terbaru
                </h3>
            </div>
            
            <div class="space-y-3">
                <?php if (empty($my_recent_work)): ?>
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada riwayat</p>
                <?php else: ?>
                    <?php foreach ($my_recent_work as $work): ?>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <p class="font-medium text-gray-800 text-sm"><?= esc($work['asset_name']) ?></p>
                            <p class="text-xs text-gray-600 mt-1"><?= esc(substr($work['diagnosis'], 0, 50)) ?>...</p>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-300">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <?= date('d M Y', strtotime($work['created_at'])) ?>
                                </span>
                                <?php if ($work['cost']): ?>
                                    <span class="text-xs font-semibold text-green-600">
                                        Rp <?= number_format($work['cost'], 0, ',', '.') ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <a href="<?= base_url('maintenance/history') ?>" class="block text-center mt-4 text-sm text-orange-500 hover:text-orange-600 font-medium">
                Lihat Semua Riwayat <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
    </div>
    
</main>

<?= view('layout/footer') ?>