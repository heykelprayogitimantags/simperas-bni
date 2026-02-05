<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('asset') ?>" class="hover:text-orange-500">Asset</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium"><?= esc($asset['asset_code']) ?></span>
        </div>
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-bold text-gray-800"><?= esc($asset['asset_name']) ?></h2>
                <p class="text-gray-600 mt-1">Detail informasi asset</p>
            </div>
            <div class="flex gap-2">
                <a href="<?= base_url('asset/edit/' . $asset['asset_id']) ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="<?= base_url('asset/delete/' . $asset['asset_id']) ?>" 
                   onclick="return confirmDelete('Apakah Anda yakin ingin menghapus asset ini?')"
                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </a>
            </div>
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

    <!-- Asset Information Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <i class="fas <?= $asset['asset_type'] === 'hardware' ? 'fa-laptop' : 'fa-code' ?> text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-orange-100 text-sm">Kode Asset</p>
                        <h3 class="text-2xl font-bold font-mono"><?= esc($asset['asset_code']) ?></h3>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm
                        <?= $asset['status'] === 'baik' ? 'bg-green-100 text-green-800' : 
                            ($asset['status'] === 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 
                            ($asset['status'] === 'rusak_berat' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) ?>">
                        <?= ucwords(str_replace('_', ' ', $asset['status'])) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Basic Info -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Informasi Dasar
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tipe:</span>
                            <span class="font-medium">
                                <span class="inline-block px-2 py-1 rounded-full text-xs
                                    <?= $asset['asset_type'] === 'hardware' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' ?>">
                                    <?= ucfirst($asset['asset_type']) ?>
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Brand:</span>
                            <span class="font-medium"><?= esc($asset['brand'] ?: '-') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Serial Number:</span>
                            <span class="font-medium font-mono text-xs"><?= esc($asset['serial_number'] ?: '-') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lokasi:</span>
                            <span class="font-medium"><?= esc($asset['location'] ?: '-') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Purchase Info -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-shopping-cart text-green-500 mr-2"></i>
                        Informasi Pembelian
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Beli:</span>
                            <span class="font-medium">
                                <?= $asset['purchase_date'] ? date('d M Y', strtotime($asset['purchase_date'])) : '-' ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Garansi s/d:</span>
                            <span class="font-medium">
                                <?php if ($asset['warranty_end_date']): ?>
                                    <?= date('d M Y', strtotime($asset['warranty_end_date'])) ?>
                                    <?php if (strtotime($asset['warranty_end_date']) < time()): ?>
                                        <span class="text-red-500 text-xs ml-1">(Habis)</span>
                                    <?php elseif (strtotime($asset['warranty_end_date']) < strtotime('+30 days')): ?>
                                        <span class="text-yellow-500 text-xs ml-1">(< 30 hari)</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-database text-purple-500 mr-2"></i>
                        Informasi Sistem
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-medium"><?= date('d M Y', strtotime($asset['created_at'])) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Terakhir Update:</span>
                            <span class="font-medium"><?= date('d M Y', strtotime($asset['updated_at'])) ?></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Specifications -->
            <?php if ($asset['specifications']): ?>
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-list-ul text-orange-500 mr-2"></i>
                        Spesifikasi / Keterangan
                    </h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-700 whitespace-pre-line"><?= esc($asset['specifications']) ?></p>
                    </div>
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
                    <p class="text-sm text-gray-400 mt-1">Asset ini belum pernah di-maintenance</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($maintenance_logs as $log): ?>
                        <div class="border-l-4 border-blue-500 bg-gray-50 p-4 rounded-r hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-semibold">
                                            #{$log['log_id']}
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