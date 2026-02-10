<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Daftar Tiket</h2>
            <p class="text-gray-600 mt-1">Semua laporan kerusakan dari pengguna</p>
        </div>
        <?php if ($user['role'] === 'pegawai'): ?>
            <a href="<?= base_url('ticket/create') ?>" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i> Lapor Kerusakan
            </a>
        <?php endif; ?>
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Tiket</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_tickets ?></h3>
                </div>
                <i class="fas fa-ticket-alt text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">Pending</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $pending ?></h3>
                </div>
                <i class="fas fa-clock text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">In Progress</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $in_progress ?></h3>
                </div>
                <i class="fas fa-spinner text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Completed</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $completed ?></h3>
                </div>
                <i class="fas fa-check-circle text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('ticket') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari Tiket
                </label>
                <input 
                    type="text" 
                    name="keyword" 
                    value="<?= $keyword ?? '' ?>"
                    placeholder="Nomor tiket, judul, atau nama asset..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-filter mr-1"></i> Status
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($status_filter ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_progress" <?= ($status_filter ?? '') === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= ($status_filter ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-exclamation-circle mr-1"></i> Prioritas
                </label>
                <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Prioritas</option>
                    <option value="low" <?= ($priority_filter ?? '') === 'low' ? 'selected' : '' ?>>Low</option>
                    <option value="medium" <?= ($priority_filter ?? '') === 'medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="high" <?= ($priority_filter ?? '') === 'high' ? 'selected' : '' ?>>High</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
                <a href="<?= base_url('ticket') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No. Tiket</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Judul</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Asset</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Pelapor</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Prioritas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($tickets)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-5xl mb-3 text-gray-300"></i>
                                <p class="font-medium">Tidak ada tiket ditemukan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded"><?= esc($ticket['ticket_number']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800"><?= esc($ticket['title']) ?></div>
                                    <div class="text-xs text-gray-500 mt-1"><?= esc(substr($ticket['description'], 0, 50)) ?>...</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-800"><?= esc($ticket['asset_name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= esc($ticket['asset_code']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?= esc($ticket['reporter_name']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $ticket['priority'] === 'high' ? 'bg-red-100 text-red-700' : 
                                            ($ticket['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                        <?= strtoupper($ticket['priority']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-700' : 
                                            ($ticket['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                        <?= $ticket['status'] === 'pending' ? 'Pending' : 
                                            ($ticket['status'] === 'in_progress' ? 'In Progress' : 'Completed') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?= date('d M Y', strtotime($ticket['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('ticket/detail/' . $ticket['ticket_id']) ?>" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <a href="<?= base_url('ticket/delete/' . $ticket['ticket_id']) ?>" 
                                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                               onclick="return confirmDelete('Apakah Anda yakin ingin menghapus tiket ini?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($tickets)): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                 <?= $pager->links('default', 'tailwind_pagination') ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?= view('layout/footer') ?>