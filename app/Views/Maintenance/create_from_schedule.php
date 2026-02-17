<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<main class="flex-1 overflow-y-auto p-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('schedule') ?>" class="hover:text-orange-500">Jadwal Perawatan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Input Log Maintenance</span>
    </div>

    <!-- Schedule Info Banner -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <p class="text-orange-100 text-sm font-semibold uppercase mb-2">Jadwal Preventive Maintenance</p>
        <h2 class="text-2xl font-bold mb-3"><?= esc($schedule['asset_name']) ?></h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-orange-100">Kode Asset</p>
                <p class="font-semibold"><?= esc($schedule['asset_code']) ?></p>
            </div>
            <div>
                <p class="text-orange-100">Tipe</p>
                <p class="font-semibold"><?= ucfirst($schedule['maintenance_type']) ?></p>
            </div>
            <div>
                <p class="text-orange-100">Tanggal Jadwal</p>
                <p class="font-semibold"><?= date('d M Y', strtotime($schedule['scheduled_date'])) ?></p>
            </div>
            <div>
                <p class="text-orange-100">Estimasi Durasi</p>
                <p class="font-semibold"><?= $schedule['estimated_duration'] ? $schedule['estimated_duration'] . ' menit' : '-' ?></p>
            </div>
        </div>
        <?php if ($schedule['notes']): ?>
            <div class="mt-4 bg-orange-400 bg-opacity-30 p-3 rounded-lg">
                <p class="text-orange-100 text-xs font-semibold mb-1">Catatan dari Admin:</p>
                <p class="text-white text-sm"><?= esc($schedule['notes']) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Error Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mr-2 mt-1"></i>
                <div>
                    <p class="font-semibold text-red-800 mb-1">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        <?php foreach (session()->getFlashdata('errors') as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Log Maintenance -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-clipboard-list text-orange-500"></i>
            Form Log Maintenance
        </h3>

        <form action="<?= base_url('maintenance/save-from-schedule/' . $schedule['schedule_id']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Diagnosis -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search text-red-500 mr-1"></i> Diagnosis / Temuan *
                </label>
                <textarea name="diagnosis" rows="4" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                    placeholder="Jelaskan kondisi asset yang ditemukan saat diperiksa...
Contoh: Ditemukan debu menumpuk pada kipas pendingin, thermal paste sudah mengering, RAM kotor..."><?= old('diagnosis') ?></textarea>
            </div>

            <!-- Action Taken -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tools text-green-500 mr-1"></i> Tindakan yang Dilakukan *
                </label>
                <textarea name="action_taken" rows="4" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                    placeholder="Jelaskan tindakan perbaikan/perawatan yang dilakukan...
Contoh: Membersihkan debu, mengganti thermal paste, lap RAM dengan alkohol, uji performa..."><?= old('action_taken') ?></textarea>
            </div>

            <!-- Parts & Cost -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-box text-blue-500 mr-1"></i> Parts / Bahan yang Digunakan
                    </label>
                    <textarea name="parts_used" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                        placeholder="Contoh: Thermal paste 1 tube, Compressed air 1 kaleng..."><?= old('parts_used') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-money-bill text-green-500 mr-1"></i> Total Biaya (Rp)
                    </label>
                    <input type="number" name="cost" min="0" step="1000"
                        value="<?= old('cost') ?>"
                        placeholder="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada biaya</p>
                </div>
            </div>

            <!-- Start & End Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-play-circle text-blue-500 mr-1"></i> Waktu Mulai
                    </label>
                    <input type="datetime-local" name="start_time"
                        value="<?= old('start_time', date('Y-m-d\TH:i')) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-stop-circle text-red-500 mr-1"></i> Waktu Selesai
                    </label>
                    <input type="datetime-local" name="end_time"
                        value="<?= old('end_time') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Simpan Log & Selesaikan Jadwal
                </button>
                <a href="<?= base_url('schedule') ?>"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>

</main>

<?= view('layout/footer') ?>