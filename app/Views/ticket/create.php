<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Lapor Kerusakan</h2>
        <p class="text-gray-600 mt-1">Laporkan masalah dengan hardware atau software Anda</p>
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
        <form action="<?= base_url('ticket/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Asset Selection -->
            <div>
                <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-laptop text-blue-500 mr-1"></i> Pilih Asset yang Bermasalah *
                </label>
                <select 
                    id="asset_id" 
                    name="asset_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    required
                    onchange="showAssetInfo()"
                >
                    <option value="">-- Pilih Asset --</option>
                    <?php foreach ($assets as $asset): ?>
                        <option value="<?= $asset['asset_id'] ?>" 
                                data-code="<?= esc($asset['asset_code']) ?>"
                                data-type="<?= esc($asset['asset_type']) ?>"
                                data-brand="<?= esc($asset['brand']) ?>"
                                data-location="<?= esc($asset['location']) ?>"
                                <?= old('asset_id') == $asset['asset_id'] ? 'selected' : '' ?>>
                            <?= esc($asset['asset_name']) ?> (<?= esc($asset['asset_code']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Asset Info Display -->
                <div id="asset-info" class="hidden mt-3 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs font-semibold text-blue-800 mb-2">Informasi Asset:</p>
                    <div class="grid grid-cols-2 gap-2 text-xs text-blue-700">
                        <div>Kode: <span id="info-code" class="font-semibold"></span></div>
                        <div>Tipe: <span id="info-type" class="font-semibold"></span></div>
                        <div>Brand: <span id="info-brand" class="font-semibold"></span></div>
                        <div>Lokasi: <span id="info-location" class="font-semibold"></span></div>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-heading text-orange-500 mr-1"></i> Judul Masalah * 
                    <span class="text-gray-400 font-normal">(min. 5 karakter)</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="<?= old('title') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Contoh: Layar laptop berkedip-kedip"
                    required
                >
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left text-purple-500 mr-1"></i> Deskripsi Masalah * 
                    <span class="text-gray-400 font-normal">(min. 10 karakter)</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Jelaskan masalah secara detail:&#10;- Kapan masalah mulai terjadi?&#10;- Apa yang sedang Anda lakukan saat masalah terjadi?&#10;- Apakah ada pesan error?&#10;- Seberapa sering masalah ini terjadi?"
                    required
                ><?= old('description') ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Semakin detail deskripsi, semakin mudah teknisi membantu Anda</p>
            </div>

            <!-- Priority -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i> Tingkat Prioritas *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- Low Priority -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                        <input 
                            type="radio" 
                            name="priority" 
                            value="low" 
                            class="sr-only peer"
                            <?= old('priority') === 'low' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-green-500 peer-checked:bg-green-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-chevron-down text-green-500 text-xl mr-2"></i>
                            <span class="font-semibold text-gray-800">Low</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Tidak mengganggu pekerjaan, bisa ditunda</p>
                    </label>
                    
                    <!-- Medium Priority -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-yellow-500 transition-colors">
                        <input 
                            type="radio" 
                            name="priority" 
                            value="medium" 
                            class="sr-only peer"
                            <?= old('priority') === 'medium' || !old('priority') ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-yellow-500 peer-checked:bg-yellow-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-minus text-yellow-500 text-xl mr-2"></i>
                            <span class="font-semibold text-gray-800">Medium</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Mengganggu pekerjaan, perlu segera ditangani</p>
                    </label>
                    
                    <!-- High Priority -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 transition-colors">
                        <input 
                            type="radio" 
                            name="priority" 
                            value="high" 
                            class="sr-only peer"
                            <?= old('priority') === 'high' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-red-500 peer-checked:bg-red-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-chevron-up text-red-500 text-xl mr-2"></i>
                            <span class="font-semibold text-gray-800">High</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Sangat mengganggu, harus segera ditangani</p>
                    </label>
                    
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan
                </button>
                <a 
                    href="<?= base_url('dashboard') ?>" 
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
                <p class="font-semibold mb-1">Tips Melaporkan Kerusakan:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Jelaskan masalah sejelas mungkin</li>
                    <li>Sebutkan kapan dan bagaimana masalah terjadi</li>
                    <li>Jika ada pesan error, tuliskan pesannya</li>
                    <li>Pilih prioritas sesuai dengan tingkat urgensi</li>
                    <li>Setelah laporan dikirim, Anda akan mendapat nomor tiket</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<script>
function showAssetInfo() {
    const select = document.getElementById('asset_id');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('asset-info');
    
    if (option.value) {
        document.getElementById('info-code').textContent = option.dataset.code;
        document.getElementById('info-type').textContent = option.dataset.type;
        document.getElementById('info-brand').textContent = option.dataset.brand || '-';
        document.getElementById('info-location').textContent = option.dataset.location || '-';
        infoDiv.classList.remove('hidden');
    } else {
        infoDiv.classList.add('hidden');
    }
}

// Show asset info if option is pre-selected (from old input)
window.addEventListener('DOMContentLoaded', showAssetInfo);
</script>

<?= view('layout/footer') ?>