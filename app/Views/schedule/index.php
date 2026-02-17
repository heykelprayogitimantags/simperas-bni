<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Jadwal Perawatan</h2>
            <p class="text-gray-600 mt-1">
                <?php if ($user['role'] === 'admin'): ?>
                    Kelola jadwal maintenance preventif & korektif
                <?php else: ?>
                    Lihat jadwal maintenance yang ditugaskan kepada Anda
                <?php endif; ?>
            </p>
        </div>
        <?php if ($user['role'] === 'admin'): ?>
            <a href="<?= base_url('schedule/create') ?>" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-calendar-plus mr-2"></i> Buat Jadwal
            </a>
        <?php else: ?>
            <div class="bg-blue-100 border border-blue-300 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-eye"></i>
                <span>View Only Mode</span>
            </div>
        <?php endif; ?>
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
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs">Total Jadwal</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $total_schedules ?></h3>
                </div>
                <i class="fas fa-calendar-alt text-3xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs">Scheduled</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $scheduled ?></h3>
                </div>
                <i class="fas fa-clock text-3xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-xs">In Progress</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $in_progress ?></h3>
                </div>
                <i class="fas fa-spinner text-3xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs">Completed</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $completed ?></h3>
                </div>
                <i class="fas fa-check-circle text-3xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs">Overdue</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $overdue ?></h3>
                </div>
                <i class="fas fa-exclamation-triangle text-3xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Today's Schedules Alert -->
    <?php if (!empty($today_schedules)): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r">
            <div class="flex items-start">
                <i class="fas fa-calendar-day text-blue-500 text-xl mr-3 mt-1"></i>
                <div class="flex-1">
                    <p class="font-semibold text-blue-800 mb-2">Jadwal Hari Ini (<?= count($today_schedules) ?> jadwal)</p>
                    <div class="space-y-2">
                        <?php foreach ($today_schedules as $ts): ?>
                            <div class="bg-white p-3 rounded shadow-sm">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800"><?= esc($ts['asset_name']) ?></p>
                                        <p class="text-xs text-gray-600 mt-1">
                                            <i class="fas fa-clock mr-1"></i> <?= $ts['scheduled_time'] ? date('H:i', strtotime($ts['scheduled_time'])) : 'Belum ditentukan' ?>
                                            <?php if ($ts['technician_name']): ?>
                                                | <i class="fas fa-user-cog mr-1"></i> <?= esc($ts['technician_name']) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full font-semibold bg-blue-100 text-blue-700">
                                        <?= ucfirst(str_replace('_', ' ', $ts['maintenance_type'])) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('schedule') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
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

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-filter mr-1"></i> Status
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="scheduled" <?= ($status_filter ?? '') === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                    <option value="in_progress" <?= ($status_filter ?? '') === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= ($status_filter ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= ($status_filter ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tools mr-1"></i> Tipe
                </label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Tipe</option>
                    <option value="preventive" <?= ($type_filter ?? '') === 'preventive' ? 'selected' : '' ?>>Preventive</option>
                    <option value="corrective" <?= ($type_filter ?? '') === 'corrective' ? 'selected' : '' ?>>Corrective</option>
                    <option value="predictive" <?= ($type_filter ?? '') === 'predictive' ? 'selected' : '' ?>>Predictive</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex-1">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="<?= base_url('schedule') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Schedules Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Asset</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tipe</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Teknisi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Durasi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($schedules)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-calendar-times text-5xl mb-3 text-gray-300"></i>
                                <p class="font-medium">Tidak ada jadwal ditemukan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">
                                        <?= date('d M Y', strtotime($schedule['scheduled_date'])) ?>
                                    </div>
                                    <?php if ($schedule['scheduled_time']): ?>
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?= date('H:i', strtotime($schedule['scheduled_time'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-800"><?= esc($schedule['asset_name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= esc($schedule['asset_code']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $schedule['maintenance_type'] === 'preventive' ? 'bg-blue-100 text-blue-700' : 
                                            ($schedule['maintenance_type'] === 'corrective' ? 'bg-orange-100 text-orange-700' : 'bg-purple-100 text-purple-700') ?>">
                                        <?= ucfirst($schedule['maintenance_type']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?= $schedule['technician_name'] ? esc($schedule['technician_name']) : '<span class="text-gray-400">Belum ditugaskan</span>' ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?= $schedule['estimated_duration'] ? $schedule['estimated_duration'] . ' menit' : '-' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $schedule['status'] === 'scheduled' ? 'bg-yellow-100 text-yellow-700' : 
                                            ($schedule['status'] === 'in_progress' ? 'bg-orange-100 text-orange-700' : 
                                            ($schedule['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700')) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $schedule['status'])) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <a href="<?= base_url('schedule/edit/' . $schedule['schedule_id']) ?>" 
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($schedule['status'] === 'scheduled'): ?>
                                                <a href="<?= base_url('schedule/delete/' . $schedule['schedule_id']) ?>" 
                                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                                   onclick="return confirmDelete('Apakah Anda yakin ingin menghapus jadwal ini?')"
                                                   title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs italic">View Only</span>
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
        <?php if (!empty($schedules)): ?>
               <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                 <?= $pager->links('default', 'tailwind_pagination') ?>
            </div>
        <?php endif; ?>
    </div>
    </div>

</main>

<?= view('layout/footer') ?>