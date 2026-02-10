<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('ticket') ?>" class="hover:text-orange-500">Tiket</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="<?= base_url('ticket/detail/' . $ticket['ticket_id']) ?>" class="hover:text-orange-500"><?= esc($ticket['ticket_number']) ?></a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Update Maintenance</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">Update Maintenance Log</h2>
        <p class="text-gray-600 mt-1">Input detail hasil perbaikan untuk tiket ini</p>
    </div>

    <!-- Ticket Info Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-blue-100 text-xs mb-1">Nomor Tiket</p>
                <p class="font-mono font-bold text-lg"><?= esc($ticket['ticket_number']) ?></p>
            </div>
            <div>
                <p class="text-blue-100 text-xs mb-1">Asset</p>
                <p class="font-semibold"><?= esc($ticket['asset_name']) ?></p>
                <p class="text-blue-100 text-xs"><?= esc($ticket['asset_code']) ?></p>
            </div>
            <div>
                <p class="text-blue-100 text-xs mb-1">Pelapor</p>
                <p class="font-semibold"><?= esc($ticket['reporter_name']) ?></p>
                <p class="text-blue-100 text-xs"><?= esc($ticket['department']) ?></p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-blue-400">
            <p class="text-blue-100 text-xs mb-1">Masalah yang Dilaporkan</p>
            <p class="font-semibold"><?= esc($ticket['title']) ?></p>
            <p class="text-blue-100 text-sm mt-2"><?= esc($ticket['description']) ?></p>
        </div>
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
        <form action="<?= base_url('maintenance/save/' . $ticket['ticket_id']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Diagnosis -->
            <div>
                <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-stethoscope text-red-500 mr-1"></i> Diagnosis * 
                    <span class="text-gray-400 font-normal">(min. 10 karakter)</span>
                </label>
                <textarea 
                    id="diagnosis" 
                    name="diagnosis" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Jelaskan apa masalahnya secara detail...&#10;Contoh:&#10;- LCD panel bermasalah, kabel fleksibel longgar&#10;- Thermal paste sudah kering&#10;- RAM tidak terdeteksi, slot RAM kotor"
                    required
                ><?= old('diagnosis', $existing_log['diagnosis'] ?? '') ?></textarea>
            </div>

            <!-- Action Taken -->
            <div>
                <label for="action_taken" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tools text-orange-500 mr-1"></i> Action Taken * 
                    <span class="text-gray-400 font-normal">(min. 10 karakter)</span>
                </label>
                <textarea 
                    id="action_taken" 
                    name="action_taken" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Jelaskan apa yang Anda lakukan untuk memperbaikinya...&#10;Contoh:&#10;- Membuka casing, mengencangkan kabel LCD, cleaning, testing&#10;- Membersihkan CPU, apply thermal paste baru, testing suhu&#10;- Membersihkan slot RAM dengan contact cleaner, reinsert RAM"
                    required
                ><?= old('action_taken', $existing_log['action_taken'] ?? '') ?></textarea>
            </div>

            <!-- Parts Used -->
            <div>
                <label for="parts_used" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-cogs text-purple-500 mr-1"></i> Parts Used
                </label>
                <textarea 
                    id="parts_used" 
                    name="parts_used" 
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Sebutkan spare parts yang digunakan (jika ada)...&#10;Contoh: Thermal Paste 1 tube, RAM DDR4 8GB 1 unit"
                ><?= old('parts_used', $existing_log['parts_used'] ?? '') ?></textarea>
            </div>

            <!-- Time & Cost -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Start Time -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-play-circle text-green-500 mr-1"></i> Waktu Mulai
                    </label>
                    <input 
                        type="datetime-local" 
                        id="start_time" 
                        name="start_time" 
                        value="<?= old('start_time', $existing_log['start_time'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

                <!-- End Time -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-stop-circle text-red-500 mr-1"></i> Waktu Selesai
                    </label>
                    <input 
                        type="datetime-local" 
                        id="end_time" 
                        name="end_time" 
                        value="<?= old('end_time', $existing_log['end_time'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

                <!-- Cost -->
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-money-bill-wave text-green-500 mr-1"></i> Biaya (Rp)
                    </label>
                    <input 
                        type="number" 
                        id="cost" 
                        name="cost" 
                        value="<?= old('cost', $existing_log['cost'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="0"
                        min="0"
                        step="1000"
                    >
                    <p class="text-xs text-gray-500 mt-1">Opsional - kosongkan jika tidak ada biaya</p>
                </div>

            </div>

            <!-- Ticket Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-flag-checkered text-blue-500 mr-1"></i> Status Tiket Setelah Perbaikan
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- In Progress -->
                    <label class="relative flex items-center p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-yellow-500 transition-colors">
                        <input 
                            type="radio" 
                            name="ticket_status" 
                            value="in_progress" 
                            class="sr-only peer"
                            <?= old('ticket_status') === 'in_progress' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-yellow-500 peer-checked:bg-yellow-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-spinner text-yellow-500 text-xl mr-3"></i>
                            <div>
                                <span class="font-semibold text-gray-800">In Progress</span>
                                <p class="text-xs text-gray-600">Masih perlu perbaikan lebih lanjut</p>
                            </div>
                        </div>
                    </label>
                    
                    <!-- Completed -->
                    <label class="relative flex items-center p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                        <input 
                            type="radio" 
                            name="ticket_status" 
                            value="completed" 
                            class="sr-only peer"
                            <?= old('ticket_status', 'completed') === 'completed' ? 'checked' : '' ?>
                        >
                        <div class="peer-checked:border-green-500 peer-checked:bg-green-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <span class="font-semibold text-gray-800">Completed</span>
                                <p class="text-xs text-gray-600">Perbaikan selesai, asset normal kembali</p>
                            </div>
                        </div>
                    </label>
                    
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-save mr-2"></i> <?= isset($existing_log) ? 'Update Log' : 'Simpan Log' ?>
                </button>
                <a 
                    href="<?= base_url('ticket/detail/' . $ticket['ticket_id']) ?>" 
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
                <p class="font-semibold mb-1">Tips Mengisi Log Maintenance:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Diagnosis:</strong> Jelaskan apa masalahnya secara teknis</li>
                    <li><strong>Action Taken:</strong> Jelaskan langkah-langkah yang dilakukan</li>
                    <li><strong>Parts Used:</strong> Catat spare parts yang terpakai (untuk stock tracking)</li>
                    <li><strong>Waktu:</strong> Isi start & end time untuk tracking durasi perbaikan</li>
                    <li><strong>Biaya:</strong> Input jika ada biaya spare parts atau jasa</li>
                    <li>Setelah save, status tiket akan otomatis diupdate</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<script>
// Auto-calculate duration when both times are filled
document.getElementById('start_time').addEventListener('change', calculateDuration);
document.getElementById('end_time').addEventListener('change', calculateDuration);

function calculateDuration() {
    const start = document.getElementById('start_time').value;
    const end = document.getElementById('end_time').value;
    
    if (start && end) {
        const startTime = new Date(start);
        const endTime = new Date(end);
        const diff = (endTime - startTime) / 1000 / 60; // minutes
        
        if (diff > 0) {
            console.log('Durasi: ' + Math.round(diff) + ' menit');
        }
    }
}
</script>

<?= view('layout/footer') ?>