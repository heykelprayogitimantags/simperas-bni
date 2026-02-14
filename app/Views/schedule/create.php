<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('schedule') ?>" class="hover:text-orange-500">Jadwal Perawatan</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Buat Jadwal Baru</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">Buat Jadwal Perawatan</h2>
        <p class="text-gray-600 mt-1">Tambahkan jadwal preventive/corrective maintenance</p>
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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <p class="text-red-700"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="<?= base_url('schedule/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Asset Selection -->
            <div>
                <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-laptop text-purple-500 mr-1"></i> Asset * 
                </label>
                <select 
                    id="asset_id" 
                    name="asset_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    required
                >
                    <option value="">-- Pilih Asset --</option>
                    <?php foreach ($assets as $asset): ?>
                        <option value="<?= $asset['asset_id'] ?>" <?= old('asset_id') == $asset['asset_id'] ? 'selected' : '' ?>>
                            <?= esc($asset['asset_code']) ?> - <?= esc($asset['asset_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Maintenance Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-tools text-orange-500 mr-1"></i> Tipe Maintenance *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- Preventive -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                        <input 
                            type="radio" 
                            name="maintenance_type" 
                            value="preventive" 
                            class="sr-only peer"
                            <?= old('maintenance_type', 'preventive') === 'preventive' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-calendar-check text-blue-500 text-2xl mr-3"></i>
                            <span class="font-semibold text-gray-800">Preventive</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Perawatan rutin terjadwal untuk mencegah kerusakan</p>
                    </label>
                    
                    <!-- Corrective -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                        <input 
                            type="radio" 
                            name="maintenance_type" 
                            value="corrective" 
                            class="sr-only peer"
                            <?= old('maintenance_type') === 'corrective' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-orange-500 peer-checked:bg-orange-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-wrench text-orange-500 text-2xl mr-3"></i>
                            <span class="font-semibold text-gray-800">Corrective</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Perbaikan setelah terjadi masalah atau kerusakan</p>
                    </label>
                    
                    <!-- Predictive -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition-colors">
                        <input 
                            type="radio" 
                            name="maintenance_type" 
                            value="predictive" 
                            class="sr-only peer"
                            <?= old('maintenance_type') === 'predictive' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-purple-500 peer-checked:bg-purple-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-chart-line text-purple-500 text-2xl mr-3"></i>
                            <span class="font-semibold text-gray-800">Predictive</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Perawatan berdasarkan monitoring dan prediksi</p>
                    </label>
                    
                </div>
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar text-green-500 mr-1"></i> Tanggal *
                    </label>
                    <input 
                        type="date" 
                        id="scheduled_date" 
                        name="scheduled_date" 
                        value="<?= old('scheduled_date') ?>"
                        min="<?= date('Y-m-d') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        required
                    >
                </div>

                <!-- Scheduled Time -->
                <div>
                    <label for="scheduled_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clock text-blue-500 mr-1"></i> Waktu (Opsional)
                    </label>
                    <input 
                        type="time" 
                        id="scheduled_time" 
                        name="scheduled_time" 
                        value="<?= old('scheduled_time') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

            </div>

            <!-- Estimated Duration & Technician -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Estimated Duration -->
                <div>
                    <label for="estimated_duration" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-hourglass-half text-yellow-500 mr-1"></i> Estimasi Durasi (menit)
                    </label>
                    <input 
                        type="number" 
                        id="estimated_duration" 
                        name="estimated_duration" 
                        value="<?= old('estimated_duration') ?>"
                        min="15"
                        step="15"
                        placeholder="Contoh: 60"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                    <p class="text-xs text-gray-500 mt-1">Opsional - Perkiraan waktu pengerjaan dalam menit</p>
                </div>

                <!-- Technician -->
                <div>
                    <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-cog text-purple-500 mr-1"></i> Teknisi
                    </label>
                    <select 
                        id="technician_id" 
                        name="technician_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                        <option value="">-- Belum Ditugaskan --</option>
                        <?php foreach ($technicians as $tech): ?>
                            <option value="<?= $tech['user_id'] ?>" <?= old('technician_id') == $tech['user_id'] ? 'selected' : '' ?>>
                                <?= esc($tech['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Opsional - Bisa ditugaskan nanti</p>
                </div>

            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note text-yellow-500 mr-1"></i> Catatan
                </label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Tambahkan catatan atau instruksi khusus untuk perawatan ini..."
                ><?= old('notes') ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-save mr-2"></i> Simpan Jadwal
                </button>
                <a 
                    href="<?= base_url('schedule') ?>" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>

        </form>
    </div>

    <!-- Info Tips -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Tips Membuat Jadwal:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Preventive:</strong> Gunakan untuk perawatan rutin berkala (harian/mingguan/bulanan)</li>
                    <li><strong>Corrective:</strong> Gunakan untuk perbaikan yang sudah terjadwal setelah ada masalah</li>
                    <li><strong>Predictive:</strong> Gunakan untuk perawatan berdasarkan monitoring kondisi asset</li>
                    <li>Jika teknisi sudah ditugaskan dan ada jadwal di waktu yang sama, sistem akan memberi peringatan</li>
                    <li>Status awal otomatis "Scheduled", bisa diubah saat maintenance dimulai</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<script>
// Auto-set recommended duration based on maintenance type
document.querySelectorAll('input[name="maintenance_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const durationType = this.value;
        const durationInput = document.getElementById('estimated_duration');
        
        if (!durationInput.value) {
            switch(durationType) {
                case 'preventive':
                    durationInput.value = 60; // 1 hour
                    break;
                case 'corrective':
                    durationInput.value = 120; // 2 hours
                    break;
                case 'predictive':
                    durationInput.value = 90; // 1.5 hours
                    break;
            }
        }
    });
});
</script>

<?= view('layout/footer') ?>