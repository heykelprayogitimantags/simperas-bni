<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('asset') ?>" class="hover:text-orange-500">Asset</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="<?= base_url('asset/detail/' . $asset['asset_id']) ?>" class="hover:text-orange-500"><?= esc($asset['asset_code']) ?></a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Edit</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">Edit Asset</h2>
        <p class="text-gray-600 mt-1">Perbarui informasi asset: <span class="font-semibold"><?= esc($asset['asset_name']) ?></span></p>
    </div>

    <!-- Error Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mr-2 mt-1"></i>
                <div class="flex-1">
                    <p class="font-semibold text-red-800 mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="<?= base_url('asset/update/' . $asset['asset_id']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Asset Info (Read-only) -->
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kode Asset</p>
                        <p class="font-mono font-semibold text-gray-800"><?= esc($asset['asset_code']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tipe Asset</p>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            <?= $asset['asset_type'] === 'hardware' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' ?>">
                            <i class="fas <?= $asset['asset_type'] === 'hardware' ? 'fa-laptop' : 'fa-code' ?> mr-1"></i>
                            <?= ucfirst($asset['asset_type']) ?>
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Dibuat Tanggal</p>
                        <p class="text-sm text-gray-800"><?= date('d M Y, H:i', strtotime($asset['created_at'])) ?></p>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Asset Name -->
                <div>
                    <label for="asset_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Asset *
                    </label>
                    <input 
                        type="text" 
                        id="asset_name" 
                        name="asset_name" 
                        value="<?= old('asset_name', $asset['asset_name']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        required
                    >
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                        Brand/Vendor
                    </label>
                    <input 
                        type="text" 
                        id="brand" 
                        name="brand" 
                        value="<?= old('brand', $asset['brand']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

                <!-- Serial Number -->
                <div>
                    <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Serial Number
                    </label>
                    <input 
                        type="text" 
                        id="serial_number" 
                        name="serial_number" 
                        value="<?= old('serial_number', $asset['serial_number']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        value="<?= old('location', $asset['location']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

            </div>

            <!-- Purchase & Warranty Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Purchase Date -->
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar text-blue-500 mr-1"></i> Tanggal Pembelian
                    </label>
                    <input 
                        type="date" 
                        id="purchase_date" 
                        name="purchase_date" 
                        value="<?= old('purchase_date', $asset['purchase_date']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

                <!-- Warranty End Date -->
                <div>
                    <label for="warranty_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shield-alt text-green-500 mr-1"></i> Tanggal Berakhir Garansi
                    </label>
                    <input 
                        type="date" 
                        id="warranty_end_date" 
                        name="warranty_end_date" 
                        value="<?= old('warranty_end_date', $asset['warranty_end_date']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                    <?php if ($asset['warranty_end_date'] && strtotime($asset['warranty_end_date']) < time()): ?>
                        <p class="text-xs text-red-500 mt-1">
                            <i class="fas fa-exclamation-circle"></i> Garansi sudah habis!
                        </p>
                    <?php elseif ($asset['warranty_end_date'] && strtotime($asset['warranty_end_date']) < strtotime('+30 days')): ?>
                        <p class="text-xs text-yellow-500 mt-1">
                            <i class="fas fa-exclamation-triangle"></i> Garansi akan habis dalam 30 hari!
                        </p>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-info-circle text-orange-500 mr-1"></i> Status *
                </label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    required
                >
                    <option value="baik" <?= old('status', $asset['status']) === 'baik' ? 'selected' : '' ?>>Baik</option>
                    <option value="rusak_ringan" <?= old('status', $asset['status']) === 'rusak_ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                    <option value="rusak_berat" <?= old('status', $asset['status']) === 'rusak_berat' ? 'selected' : '' ?>>Rusak Berat</option>
                    <option value="retired" <?= old('status', $asset['status']) === 'retired' ? 'selected' : '' ?>>Retired</option>
                </select>
            </div>

            <!-- Specifications -->
            <div>
                <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-list-ul text-purple-500 mr-1"></i> Spesifikasi / Keterangan
                </label>
                <textarea 
                    id="specifications" 
                    name="specifications" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                ><?= old('specifications', $asset['specifications']) ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <a 
                    href="<?= base_url('asset/detail/' . $asset['asset_id']) ?>" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>

        </form>
    </div>

</main>

<?= view('layout/footer') ?>