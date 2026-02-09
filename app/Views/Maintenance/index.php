<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Log Maintenance</h2>
        <p class="text-gray-600 mt-1">Riwayat semua perbaikan yang telah dilakukan</p>
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Perbaikan</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_logs ?></h3>
                    <p class="text-blue-100 text-xs mt-1">Semua periode</p>
                </div>
                <i class="fas fa-wrench text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Bulan Ini</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $this_month ?></h3>
                    <p class="text-green-100 text-xs mt-1"><?= date('F Y') ?></p>
                </div>
                <i class="fas fa-calendar-check text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Total Biaya Bulan Ini</p>
                    <h3 class="text-2xl font-bold mt-1">Rp <?= number_format($total_cost, 0, ',', '.') ?></h3>
                    <p class="text-orange-100 text-xs mt-1">Maintenance cost</p>
                </div>
                <i class="fas fa-money-bill-wave text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('maintenance') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari
                </label>
                <input 
                    type="text" 
                    name="keyword" 
                    value="<?= $keyword ?? '' ?>"
                    placeholder="Asset, diagnosis, atau action..."
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
                <a href="<?= base_url('maintenance') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Maintenance Logs Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Asset</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Teknisi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Diagnosis</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Action</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Durasi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Biaya</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-clipboard-list text-5xl mb-3 text-gray-300"></i>
                                <p class="font-medium">Tidak ada log maintenance ditemukan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-800">
                                        <?= date('d M Y', strtotime($log['created_at'])) ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?= date('H:i', strtotime($log['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800"><?= esc($log['asset_name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= esc($log['asset_code']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?= esc($log['technician_name']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs">
                                        <?= esc(substr($log['diagnosis'], 0, 60)) ?><?= strlen($log['diagnosis']) > 60 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs">
                                        <?= esc(substr($log['action_taken'], 0, 60)) ?><?= strlen($log['action_taken']) > 60 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?php if ($log['start_time'] && $log['end_time']): ?>
                                        <?php
                                            $start = strtotime($log['start_time']);
                                            $end = strtotime($log['end_time']);
                                            $duration = round(($end - $start) / 60);
                                            echo $duration . ' menit';
                                        ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($log['cost']): ?>
                                        <span class="text-sm font-semibold text-green-600">
                                            Rp <?= number_format($log['cost'], 0, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('maintenance/detail/' . $log['log_id']) ?>" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <a href="<?= base_url('maintenance/delete/' . $log['log_id']) ?>" 
                                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                               onclick="return confirmDelete('Apakah Anda yakin ingin menghapus log ini?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($logs)): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?= view('layout/footer') ?>