<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('asset') ?>" class="hover:text-orange-500">Asset</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Tambah Asset</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">Tambah Asset Baru</h2>
        <p class="text-gray-600 mt-1">Tambahkan hardware atau software baru ke sistem</p>
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
        <form action="<?= base_url('asset/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Asset Type Selection -->
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-l-4 border-orange-500 p-4 rounded-r">
                <label class="block text-sm font-semibold text-gray-800 mb-3">
                    <i class="fas fa-layer-group mr-2 text-orange-500"></i> Tipe Asset *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative flex items-center p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                        <input 
                            type="radio" 
                            name="asset_type" 
                            value="hardware" 
                            class="w-5 h-5 text-orange-500 focus:ring-orange-500"
                            <?= old('asset_type') === 'hardware' ? 'checked' : '' ?>
                            required
                        >
                        <div class="ml-3">
                            <div class="flex items-center">
                                <i class="fas fa-laptop text-purple-500 text-xl mr-2"></i>
                                <span class="font-semibold text-gray-800">Hardware</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Komputer, laptop, printer, dll</p>
                        </div>
                    </label>
                    
                    <label class="relative flex items-center p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                        <input 
                            type="radio" 
                            name="asset_type" 
                            value="software" 
                            class="w-5 h-5 text-orange-500 focus:ring-orange-500"
                            <?= old('asset_type') === 'software' ? 'checked' : '' ?>
                            required
                        >
                        <div class="ml-3">
                            <div class="flex items-center">
                                <i class="fas fa-code text-green-500 text-xl mr-2"></i>
                                <span class="font-semibold text-gray-800">Software</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Aplikasi, lisensi, sistem operasi</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Asset Name -->
                <div>
                    <label for="asset_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Asset * <span class="text-gray-400 font-normal">(min. 3 karakter)</span>
                    </label>
                    <input 
                        type="text" 
                        id="asset_name" 
                        name="asset_name" 
                        value="<?= old('asset_name') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Contoh: Dell Latitude 5420"
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
                        value="<?= old('brand') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Contoh: Dell, HP, Microsoft"
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
                        value="<?= old('serial_number') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Contoh: ABC123XYZ456"
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
                        value="<?= old('location') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Contoh: Kantor Pusat Lt. 5, Ruang IT"
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
                        value="<?= old('purchase_date') ?>"
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
                        value="<?= old('warranty_end_date') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
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
                    <option value="baik" <?= old('status') === 'baik' ? 'selected' : '' ?>>Baik</option>
                    <option value="rusak_ringan" <?= old('status') === 'rusak_ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                    <option value="rusak_berat" <?= old('status') === 'rusak_berat' ? 'selected' : '' ?>>Rusak Berat</option>
                    <option value="retired" <?= old('status') === 'retired' ? 'selected' : '' ?>>Retired</option>
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
                    placeholder="Contoh: Intel Core i5-11th Gen, 8GB RAM, 256GB SSD, Windows 11 Pro"
                ><?= old('specifications') ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Tuliskan spesifikasi lengkap atau keterangan tambahan</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-save mr-2"></i> Simpan Asset
                </button>
                <a 
                    href="<?= base_url('asset') ?>" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>

        </form>
    </div>

    <!-- Info Note -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Informasi:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Kode asset akan di-generate otomatis oleh sistem</li>
                    <li>Format kode: HW-YYYY-XXX (Hardware) atau SW-YYYY-XXX (Software)</li>
                    <li>Field bertanda * wajib diisi</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<?= view('layout/footer') ?>