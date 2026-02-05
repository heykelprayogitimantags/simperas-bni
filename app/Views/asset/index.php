<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Kelola Asset</h2>
            <p class="text-gray-600 mt-1">Manajemen Hardware & Software</p>
        </div>
        <a href="<?= base_url('asset/create') ?>" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Asset
        </a>
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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded alert-auto-hide">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <p class="text-red-700"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Asset</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_assets ?></h3>
                </div>
                <i class="fas fa-database text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Hardware</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_hardware ?></h3>
                </div>
                <i class="fas fa-laptop text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Software</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_software ?></h3>
                </div>
                <i class="fas fa-code text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('asset') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari Asset
                </label>
                <input 
                    type="text" 
                    name="keyword" 
                    value="<?= $keyword ?? '' ?>"
                    placeholder="Nama, kode, brand, atau serial number..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-filter mr-1"></i> Tipe
                </label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Tipe</option>
                    <option value="hardware" <?= ($type_filter ?? '') === 'hardware' ? 'selected' : '' ?>>Hardware</option>
                    <option value="software" <?= ($type_filter ?? '') === 'software' ? 'selected' : '' ?>>Software</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-info-circle mr-1"></i> Status
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="baik" <?= ($status_filter ?? '') === 'baik' ? 'selected' : '' ?>>Baik</option>
                    <option value="rusak_ringan" <?= ($status_filter ?? '') === 'rusak_ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                    <option value="rusak_berat" <?= ($status_filter ?? '') === 'rusak_berat' ? 'selected' : '' ?>>Rusak Berat</option>
                    <option value="retired" <?= ($status_filter ?? '') === 'retired' ? 'selected' : '' ?>>Retired</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
                <a href="<?= base_url('asset') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Asset Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kode Asset</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Asset</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tipe</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Brand</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Lokasi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($assets)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-5xl mb-3 text-gray-300"></i>
                                <p class="font-medium">Tidak ada asset ditemukan</p>
                                <p class="text-sm mt-1">Silakan tambah asset baru atau ubah filter pencarian</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assets as $asset): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded"><?= esc($asset['asset_code']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800"><?= esc($asset['asset_name']) ?></div>
                                    <?php if ($asset['serial_number']): ?>
                                        <div class="text-xs text-gray-500">SN: <?= esc($asset['serial_number']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $asset['asset_type'] === 'hardware' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' ?>">
                                        <i class="fas <?= $asset['asset_type'] === 'hardware' ? 'fa-laptop' : 'fa-code' ?> mr-1"></i>
                                        <?= ucfirst($asset['asset_type']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?= esc($asset['brand'] ?: '-') ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= esc($asset['location'] ?: '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $asset['status'] === 'baik' ? 'bg-green-100 text-green-700' : 
                                            ($asset['status'] === 'rusak_ringan' ? 'bg-yellow-100 text-yellow-700' : 
                                            ($asset['status'] === 'rusak_berat' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) ?>">
                                        <?= ucwords(str_replace('_', ' ', $asset['status'])) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('asset/detail/' . $asset['asset_id']) ?>" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('asset/edit/' . $asset['asset_id']) ?>" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('asset/delete/' . $asset['asset_id']) ?>" 
                                           class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           onclick="return confirmDelete('Apakah Anda yakin ingin menghapus asset ini?')"
                                           title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($assets)): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?= view('layout/footer') ?>