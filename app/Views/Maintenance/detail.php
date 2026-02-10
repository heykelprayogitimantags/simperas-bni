<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Detail Log Maintenance</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap perbaikan yang telah dilakukan</p>
        </div>
        <a href="<?= base_url('maintenance') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Log Maintenance #<?= $log['log_id'] ?></h3>
                    <p class="text-orange-100 text-sm mt-2">
                        <i class="fas fa-calendar mr-2"></i>
                        <?= date('l, d F Y', strtotime($log['created_at'])) ?>
                    </p>
                    <p class="text-orange-100 text-sm mt-1">
                        <i class="fas fa-clock mr-2"></i>
                        <?= date('H:i', strtotime($log['created_at'])) ?> WIB
                    </p>
                </div>
                <div class="text-right">
                    <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                        <p class="text-orange-100 text-xs">Total Biaya</p>
                        <p class="text-white font-bold text-2xl mt-1">
                            Rp <?= number_format($log['cost'], 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 space-y-8">
            
            <!-- Asset & Ticket Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Asset Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h4 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                        <i class="fas fa-laptop text-blue-600 mr-2"></i> Informasi Asset
                    </h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-blue-600 mb-1 font-semibold">Nama Asset</p>
                            <p class="text-gray-800 font-semibold text-lg"><?= esc($log['asset_name']) ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-blue-600 mb-1 font-semibold">Kode Asset</p>
                            <p class="text-gray-700 font-mono bg-white px-3 py-2 rounded border border-blue-200">
                                <?= esc($log['asset_code']) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Ticket Info -->
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <h4 class="text-lg font-bold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-ticket-alt text-green-600 mr-2"></i> Informasi Tiket
                    </h4>
                    <div class="space-y-3">
                        <?php if (!empty($log['ticket_number'])): ?>
                            <div>
                                <p class="text-xs text-green-600 mb-1 font-semibold">Nomor Tiket</p>
                                <p class="text-gray-800 font-mono bg-white px-3 py-2 rounded border border-green-200 font-semibold">
                                    <?= esc($log['ticket_number']) ?>
                                </p>
                            </div>
                            <?php if (!empty($log['ticket_title'])): ?>
                                <div>
                                    <p class="text-xs text-green-600 mb-1 font-semibold">Judul Tiket</p>
                                    <p class="text-gray-700"><?= esc($log['ticket_title']) ?></p>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center text-gray-400 py-4">
                                <i class="fas fa-info-circle text-2xl mb-2"></i>
                                <p class="text-sm">Tidak ada tiket terkait</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Technician Info -->
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-purple-800 mb-3 flex items-center">
                    <i class="fas fa-user-cog text-purple-600 mr-2"></i> Teknisi yang Menangani
                </h4>
                <div class="flex items-center gap-4">
                    <div class="bg-purple-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold">
                        <?= strtoupper(substr($log['technician_name'], 0, 1)) ?>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-lg"><?= esc($log['technician_name']) ?></p>
                        <p class="text-sm text-gray-600">Teknisi IT</p>
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-red-800 mb-4 flex items-center">
                    <i class="fas fa-stethoscope text-red-600 mr-2"></i> Diagnosis Masalah
                </h4>
                <div class="bg-white rounded-lg p-4 border border-red-200">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line"><?= esc($log['diagnosis']) ?></p>
                </div>
            </div>

            <!-- Action Taken -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-yellow-800 mb-4 flex items-center">
                    <i class="fas fa-tools text-yellow-600 mr-2"></i> Tindakan Perbaikan
                </h4>
                <div class="bg-white rounded-lg p-4 border border-yellow-200">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line"><?= esc($log['action_taken']) ?></p>
                </div>
            </div>

            <!-- Parts Used -->
            <?php if (!empty($log['parts_used'])): ?>
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6">
                    <h4 class="text-lg font-bold text-indigo-800 mb-4 flex items-center">
                        <i class="fas fa-cogs text-indigo-600 mr-2"></i> Suku Cadang yang Digunakan
                    </h4>
                    <div class="bg-white rounded-lg p-4 border border-indigo-200">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line"><?= esc($log['parts_used']) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Time & Duration -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-blue-100 text-sm font-semibold">Waktu Mulai</p>
                        <i class="fas fa-play-circle text-2xl opacity-50"></i>
                    </div>
                    <?php if ($log['start_time']): ?>
                        <p class="text-2xl font-bold">
                            <?= date('H:i', strtotime($log['start_time'])) ?>
                        </p>
                        <p class="text-blue-100 text-xs mt-1">
                            <?= date('d M Y', strtotime($log['start_time'])) ?>
                        </p>
                    <?php else: ?>
                        <p class="text-blue-100 text-sm">-</p>
                    <?php endif; ?>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-green-100 text-sm font-semibold">Waktu Selesai</p>
                        <i class="fas fa-stop-circle text-2xl opacity-50"></i>
                    </div>
                    <?php if ($log['end_time']): ?>
                        <p class="text-2xl font-bold">
                            <?= date('H:i', strtotime($log['end_time'])) ?>
                        </p>
                        <p class="text-green-100 text-xs mt-1">
                            <?= date('d M Y', strtotime($log['end_time'])) ?>
                        </p>
                    <?php else: ?>
                        <p class="text-green-100 text-sm">-</p>
                    <?php endif; ?>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-purple-100 text-sm font-semibold">Total Durasi</p>
                        <i class="fas fa-hourglass-half text-2xl opacity-50"></i>
                    </div>
                    <?php if ($log['start_time'] && $log['end_time']): ?>
                        <?php
                            $start = strtotime($log['start_time']);
                            $end = strtotime($log['end_time']);
                            $durationMinutes = round(($end - $start) / 60);
                            $hours = floor($durationMinutes / 60);
                            $minutes = $durationMinutes % 60;
                        ?>
                        <p class="text-2xl font-bold">
                            <?php if ($hours > 0): ?>
                                <?= $hours ?> jam <?= $minutes ?> menit
                            <?php else: ?>
                                <?= $minutes ?> menit
                            <?php endif; ?>
                        </p>
                        <p class="text-purple-100 text-xs mt-1">Waktu pengerjaan</p>
                    <?php else: ?>
                        <p class="text-purple-100 text-sm">-</p>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Cost Summary -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm mb-1">Total Biaya Perbaikan</p>
                        <h3 class="text-4xl font-bold">Rp <?= number_format($log['cost'], 0, ',', '.') ?></h3>
                        <p class="text-orange-100 text-xs mt-2">Termasuk biaya suku cadang dan jasa</p>
                    </div>
                    <i class="fas fa-money-bill-wave text-6xl opacity-30"></i>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-4">
                <a href="<?= base_url('maintenance') ?>" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold text-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
                <?php if ($user['role'] === 'admin'): ?>
                    <a href="<?= base_url('maintenance/delete/' . $log['log_id']) ?>" 
                       class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors"
                       onclick="return confirm('Apakah Anda yakin ingin menghapus log ini?')">
                        <i class="fas fa-trash mr-2"></i> Hapus Log
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

</main>

<script>
function confirmDelete(message) {
    return confirm(message);
}
</script>

<?= view('layout/footer') ?>