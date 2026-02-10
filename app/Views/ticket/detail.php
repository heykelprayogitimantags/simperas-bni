<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('ticket') ?>" class="hover:text-orange-500">Tiket</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium"><?= esc($ticket['ticket_number']) ?></span>
        </div>
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-bold text-gray-800"><?= esc($ticket['title']) ?></h2>
                <p class="text-gray-600 mt-1">Detail informasi tiket</p>
            </div>
            <?php if ($user['role'] === 'admin' || $user['role'] === 'teknisi'): ?>
                <div class="flex gap-2">
                    <a href="<?= base_url('maintenance/update/' . $ticket['ticket_id']) ?>" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-wrench mr-2"></i> Update Maintenance
                    </a>
                    <?php if ($user['role'] === 'admin'): ?>
                        <a href="<?= base_url('ticket/delete/' . $ticket['ticket_id']) ?>" 
                           onclick="return confirmDelete('Apakah Anda yakin ingin menghapus tiket ini?')"
                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded alert-auto-hide">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <p class="text-green-700"><?= session()->getFlashdata('success') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Ticket Information Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <i class="fas fa-ticket-alt text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-orange-100 text-sm">Nomor Tiket</p>
                        <h3 class="text-2xl font-bold font-mono"><?= esc($ticket['ticket_number']) ?></h3>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm
                        <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-800' : 
                            ($ticket['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                        <?php
                            $statusText = [
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed'
                            ];
                            echo $statusText[$ticket['status']] ?? $ticket['status'];
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Ticket Info -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Informasi Tiket
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prioritas:</span>
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                <?= $ticket['priority'] === 'high' ? 'bg-red-100 text-red-700' : 
                                    ($ticket['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                <?= strtoupper($ticket['priority']) ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">
                                <?= $statusText[$ticket['status']] ?? $ticket['status'] ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-medium"><?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Asset Info -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-laptop text-purple-500 mr-2"></i>
                        Asset Terkait
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium"><?= esc($ticket['asset_name']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kode:</span>
                            <span class="font-medium font-mono"><?= esc($ticket['asset_code']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tipe:</span>
                            <span class="font-medium"><?= ucfirst($ticket['asset_type']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Reporter Info -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user text-green-500 mr-2"></i>
                        Pelapor
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium"><?= esc($ticket['reporter_name']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Department:</span>
                            <span class="font-medium"><?= esc($ticket['department'] ?: '-') ?></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Description -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-align-left text-orange-500 mr-2"></i>
                    Deskripsi Masalah
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line"><?= esc($ticket['description']) ?></p>
                </div>
            </div>

            <!-- Change Status (Admin/Teknisi only) -->
            <?php if (($user['role'] === 'admin' || $user['role'] === 'teknisi') && $ticket['status'] !== 'completed'): ?>
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-3">Ubah Status Tiket</h4>
                    <form action="<?= base_url('ticket/update-status/' . $ticket['ticket_id']) ?>" method="POST" class="flex gap-3">
                        <?= csrf_field() ?>
                        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500" required>
                            <option value="pending" <?= $ticket['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="in_progress" <?= $ticket['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="completed" <?= $ticket['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i> Update Status
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Maintenance History -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-history mr-2"></i>
                    Riwayat Maintenance
                </h3>
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold">
                    <?= count($maintenance_logs) ?> Records
                </span>
            </div>
        </div>

        <div class="p-6">
            <?php if (empty($maintenance_logs)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Belum ada riwayat maintenance</p>
                    <p class="text-sm text-gray-400 mt-1">Tiket ini belum ditangani oleh teknisi</p>
                    <?php if ($user['role'] === 'admin' || $user['role'] === 'teknisi'): ?>
                        <a href="<?= base_url('maintenance/update/' . $ticket['ticket_id']) ?>" class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-wrench mr-2"></i> Update Maintenance Sekarang
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($maintenance_logs as $log): ?>
                        <div class="border-l-4 border-blue-500 bg-gray-50 p-4 rounded-r hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-semibold">
                                            Log #<?= $log['log_id'] ?>
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-user-cog mr-1"></i>
                                            <?= esc($log['technician_name']) ?>
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-calendar mr-1"></i>
                                            <?= date('d M Y, H:i', strtotime($log['created_at'])) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-500 font-semibold mb-1">Diagnosis:</p>
                                        <p class="text-sm text-gray-700"><?= esc($log['diagnosis']) ?></p>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-500 font-semibold mb-1">Action Taken:</p>
                                        <p class="text-sm text-gray-700"><?= esc($log['action_taken']) ?></p>
                                    </div>

                                    <?php if ($log['parts_used']): ?>
                                        <div class="mb-2">
                                            <p class="text-xs text-gray-500 font-semibold mb-1">Parts Used:</p>
                                            <p class="text-sm text-gray-700"><?= esc($log['parts_used']) ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($log['start_time'] && $log['end_time']): ?>
                                        <div class="flex items-center gap-4 text-xs text-gray-600 mt-2">
                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                Duration: 
                                                <?php
                                                    $start = strtotime($log['start_time']);
                                                    $end = strtotime($log['end_time']);
                                                    $duration = round(($end - $start) / 60);
                                                    echo $duration . ' menit';
                                                ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($log['cost']): ?>
                                    <div class="text-right ml-4">
                                        <p class="text-xs text-gray-500">Biaya</p>
                                        <p class="text-lg font-bold text-green-600">
                                            Rp <?= number_format($log['cost'], 0, ',', '.') ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<?= view('layout/footer') ?>