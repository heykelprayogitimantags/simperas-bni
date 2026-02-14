<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('schedule') ?>" class="hover:text-orange-500">Jadwal Perawatan</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Edit Jadwal</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">Edit Jadwal Perawatan</h2>
        <p class="text-gray-600 mt-1">Update informasi jadwal maintenance</p>
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

    <!-- Current Schedule Info -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-xl font-bold mb-2">Informasi Jadwal Saat Ini</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-blue-100">Asset</p>
                        <p class="font-semibold"><?= esc($schedule['asset_name']) ?></p>
                        <p class="text-blue-100 text-xs"><?= esc($schedule['asset_code']) ?></p>
                    </div>
                    <div>
                        <p class="text-blue-100">Tanggal & Waktu</p>
                        <p class="font-semibold"><?= date('d M Y', strtotime($schedule['scheduled_date'])) ?></p>
                        <p class="text-blue-100 text-xs">
                            <?= $schedule['scheduled_time'] ? date('H:i', strtotime($schedule['scheduled_time'])) : 'Belum ditentukan' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-blue-100">Status</p>
                        <span class="inline-block mt-1 px-3 py-1 text-xs font-semibold rounded-full bg-white text-blue-700">
                            <?= ucfirst(str_replace('_', ' ', $schedule['status'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="<?= base_url('schedule/update/' . $schedule['schedule_id']) ?>" method="POST" class="space-y-6">
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
                        <option value="<?= $asset['asset_id'] ?>" 
                            <?= $schedule['asset_id'] == $asset['asset_id'] ? 'selected' : '' ?>>
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
                            <?= $schedule['maintenance_type'] === 'preventive' ? 'checked' : '' ?>
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
                            <?= $schedule['maintenance_type'] === 'corrective' ? 'checked' : '' ?>
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
                            <?= $schedule['maintenance_type'] === 'predictive' ? 'checked' : '' ?>
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
                        value="<?= $schedule['scheduled_date'] ?>"
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
                        value="<?= $schedule['scheduled_time'] ?>"
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
                        value="<?= $schedule['estimated_duration'] ?>"
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
                            <option value="<?= $tech['user_id'] ?>" 
                                <?= $schedule['technician_id'] == $tech['user_id'] ? 'selected' : '' ?>>
                                <?= esc($tech['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Opsional - Bisa ditugaskan nanti</p>
                </div>

            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-flag-checkered text-red-500 mr-1"></i> Status *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    
                    <label class="relative flex items-center p-3 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-yellow-500 transition-colors">
                        <input 
                            type="radio" 
                            name="status" 
                            value="scheduled" 
                            class="sr-only peer"
                            <?= $schedule['status'] === 'scheduled' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-yellow-500 peer-checked:bg-yellow-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-clock text-yellow-500 mr-2"></i>
                            <span class="font-semibold text-sm">Scheduled</span>
                        </div>
                    </label>
                    
                    <label class="relative flex items-center p-3 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                        <input 
                            type="radio" 
                            name="status" 
                            value="in_progress" 
                            class="sr-only peer"
                            <?= $schedule['status'] === 'in_progress' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-orange-500 peer-checked:bg-orange-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-spinner text-orange-500 mr-2"></i>
                            <span class="font-semibold text-sm">In Progress</span>
                        </div>
                    </label>
                    
                    <label class="relative flex items-center p-3 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                        <input 
                            type="radio" 
                            name="status" 
                            value="completed" 
                            class="sr-only peer"
                            <?= $schedule['status'] === 'completed' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-green-500 peer-checked:bg-green-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="font-semibold text-sm">Completed</span>
                        </div>
                    </label>
                    
                    <label class="relative flex items-center p-3 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-gray-500 transition-colors">
                        <input 
                            type="radio" 
                            name="status" 
                            value="cancelled" 
                            class="sr-only peer"
                            <?= $schedule['status'] === 'cancelled' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-gray-500 peer-checked:bg-gray-50 absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-times-circle text-gray-500 mr-2"></i>
                            <span class="font-semibold text-sm">Cancelled</span>
                        </div>
                    </label>
                    
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
                ><?= esc($schedule['notes']) ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-save mr-2"></i> Update Jadwal
                </button>
                <a 
                    href="<?= base_url('schedule') ?>" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <?php if ($schedule['status'] === 'scheduled'): ?>
                    <a 
                        href="<?= base_url('schedule/delete/' . $schedule['schedule_id']) ?>" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"
                        class="ml-auto bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium transition-colors"
                    >
                        <i class="fas fa-trash mr-2"></i> Hapus Jadwal
                    </a>
                <?php endif; ?>
            </div>

        </form>
    </div>

    <!-- Info Note -->
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-yellow-500 mr-2 mt-1"></i>
            <div class="text-sm text-yellow-800">
                <p class="font-semibold mb-1">Catatan Penting:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Jadwal hanya bisa dihapus jika status masih "Scheduled"</li>
                    <li>Jika sudah "In Progress" atau "Completed", jadwal tidak bisa dihapus</li>
                    <li>Mengubah teknisi akan otomatis dicek konflik jadwal</li>
                    <li>Status "Completed" biasanya diset otomatis saat maintenance log dibuat</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<?= view('layout/footer') ?>