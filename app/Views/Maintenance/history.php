<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Riwayat Pekerjaan Saya</h2>
        <p class="text-gray-600 mt-1">Log semua perbaikan yang telah saya selesaikan</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded alert-auto-hide">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <p class="text-green-700"><?= session()->getFlashdata('success') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Pekerjaan</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_work ?></h3>
                    <p class="text-blue-100 text-xs mt-1">Semua periode</p>
                </div>
                <i class="fas fa-wrench text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Bulan Ini</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $month ?></h3>
                    <p class="text-green-100 text-xs mt-1"><?= date('F Y') ?></p>
                </div>
                <i class="fas fa-calendar-check text-4xl opacity-50"></i>
            </div>
        </div>

    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('maintenance/history') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari
                </label>
                <input 
                    type="text" 
                    name="keyword" 
                    value="<?= $keyword ?? '' ?>"
                    placeholder="Asset atau diagnosis..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>

            <!-- Month Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar mr-1"></i> Bulan
                </label>
                <input 
                    type="month" 
                    name="month" 
                    value="<?= $month_filter ?? date('Y-m') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex-1">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="<?= base_url('maintenance/history') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Maintenance Logs List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        
        <?php if (empty($logs)): ?>
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="mb-6">
                    <i class="fas fa-clipboard-list text-gray-300 text-8xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-500 mb-6">Anda belum menyelesaikan pekerjaan perbaikan</p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 max-w-md mx-auto text-left">
                    <p class="text-sm text-blue-800 mb-3 font-semibold">
                        <i class="fas fa-lightbulb mr-2"></i> Mulai bekerja:
                    </p>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li>• Lihat tiket yang perlu dikerjakan</li>
                        <li>• Kerjakan perbaikan asset</li>
                        <li>• Update maintenance log</li>
                        <li>• Riwayat akan muncul di sini</li>
                    </ul>
                </div>
                <div class="mt-6">
                    <a href="<?= base_url('ticket') ?>" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                        <i class="fas fa-ticket-alt mr-2"></i> Lihat Tiket
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Log Cards -->
            <div class="p-6 space-y-4">
                <?php foreach ($logs as $log): ?>
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                        
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-hashtag"></i> Log <?= $log['log_id'] ?>
                                    </span>
                                    <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded font-semibold">
                                        <i class="fas fa-calendar"></i> 
                                        <?= date('d M Y, H:i', strtotime($log['created_at'])) ?>
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800 mb-1">
                                    <i class="fas fa-laptop text-purple-500 mr-2"></i>
                                    <?= esc($log['asset_name']) ?>
                                </h4>
                                <p class="text-sm text-gray-500"><?= esc($log['asset_code']) ?></p>
                            </div>
                            <?php if ($log['cost']): ?>
                                <div class="text-right ml-4">
                                    <p class="text-xs text-gray-500">Biaya</p>
                                    <p class="text-xl font-bold text-green-600">
                                        Rp <?= number_format($log['cost'], 0, ',', '.') ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Diagnosis & Action -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="bg-red-50 rounded-lg p-4">
                                <p class="text-xs font-semibold text-red-700 mb-2 flex items-center">
                                    <i class="fas fa-stethoscope mr-2"></i> DIAGNOSIS
                                </p>
                                <p class="text-sm text-gray-700"><?= esc($log['diagnosis']) ?></p>
                            </div>
                            
                            <div class="bg-green-50 rounded-lg p-4">
                                <p class="text-xs font-semibold text-green-700 mb-2 flex items-center">
                                    <i class="fas fa-tools mr-2"></i> ACTION TAKEN
                                </p>
                                <p class="text-sm text-gray-700"><?= esc($log['action_taken']) ?></p>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <?php if ($log['parts_used']): ?>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">
                                            <i class="fas fa-cogs text-purple-500 mr-1"></i> Parts Used
                                        </p>
                                        <p class="font-semibold text-gray-800"><?= esc($log['parts_used']) ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($log['start_time'] && $log['end_time']): ?>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">
                                            <i class="fas fa-clock text-blue-500 mr-1"></i> Durasi
                                        </p>
                                        <p class="font-semibold text-gray-800">
                                            <?php
                                                $start = strtotime($log['start_time']);
                                                $end = strtotime($log['end_time']);
                                                $duration = round(($end - $start) / 60);
                                                echo $duration . ' menit';
                                            ?>
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">
                                            <i class="fas fa-hourglass-start text-yellow-500 mr-1"></i> Waktu Kerja
                                        </p>
                                        <p class="font-semibold text-gray-800">
                                            <?= date('H:i', strtotime($log['start_time'])) ?> - 
                                            <?= date('H:i', strtotime($log['end_time'])) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4 flex gap-2">
                            <a href="<?= base_url('maintenance/detail/' . $log['log_id']) ?>" 
                               class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-eye mr-2"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
                <<!-- Pagination -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <?php if ($pager): ?>
            <?= $pager->links('default', 'tailwind_pagination') ?>
        <?php endif; ?>
    </div>
        <?php endif; ?>

    </div>

</main>

<?= view('layout/footer') ?>