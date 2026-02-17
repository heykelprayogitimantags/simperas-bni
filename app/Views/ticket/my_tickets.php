<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Tiket Saya</h2>
        <p class="text-gray-600 mt-1">Pantau status laporan kerusakan Anda</p>
    </div>

    <!-- Quick Action -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold mb-1">Ada Masalah Baru?</h3>
                <p class="text-orange-100 text-sm">Laporkan sekarang juga!</p>
            </div>
            <a href="<?= base_url('ticket/create') ?>" class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:bg-orange-50 transition-colors">
                <i class="fas fa-plus-circle mr-2"></i> Lapor Kerusakan
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Tiket</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $total ?></h3>
                </div>
                <i class="fas fa-ticket-alt text-blue-500 text-3xl opacity-50"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Pending</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $pending ?></h3>
                </div>
                <i class="fas fa-clock text-red-500 text-3xl opacity-50"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">In Progress</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $in_progress ?></h3>
                </div>
                <i class="fas fa-spinner text-yellow-500 text-3xl opacity-50"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Completed</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $completed ?></h3>
                </div>
                <i class="fas fa-check-circle text-green-500 text-3xl opacity-50"></i>
            </div>
        </div>

    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('ticket/my-tickets') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Search -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari Tiket
                </label>
                <input 
                    type="text" 
                    name="keyword" 
                    value="<?= $keyword ?? '' ?>"
                    placeholder="Nomor tiket atau judul..."
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

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex-1">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
                <a href="<?= base_url('ticket/my-tickets') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Tickets List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        
        <?php if (empty($tickets)): ?>
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="mb-6">
                    <i class="fas fa-inbox text-gray-300 text-8xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Tiket</h3>
                <p class="text-gray-500 mb-6">Anda belum pernah melaporkan kerusakan</p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 max-w-md mx-auto text-left">
                    <p class="text-sm text-blue-800 mb-3 font-semibold">
                        <i class="fas fa-lightbulb mr-2"></i> Tips:
                    </p>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li>• Laporkan masalah sesegera mungkin</li>
                        <li>• Jelaskan masalah dengan detail</li>
                        <li>• Pilih prioritas yang sesuai</li>
                    </ul>
                </div>
                <div class="mt-6">
                    <a href="<?= base_url('ticket/create') ?>" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                        <i class="fas fa-plus-circle mr-2"></i> Buat Tiket Pertama
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Ticket Cards -->
            <div class="p-6 space-y-4">
                <?php foreach ($tickets as $ticket): ?>
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-orange-300 hover:shadow-lg transition-all">
                        
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-mono text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded font-semibold">
                                        <?= esc($ticket['ticket_number']) ?>
                                    </span>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $ticket['priority'] === 'high' ? 'bg-red-100 text-red-700' : 
                                            ($ticket['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        <?= strtoupper($ticket['priority']) ?> PRIORITY
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800 mb-2"><?= esc($ticket['title']) ?></h4>
                                <p class="text-sm text-gray-600 mb-3"><?= esc($ticket['description']) ?></p>
                            </div>
                            <div class="ml-4">
                                <span class="inline-block px-4 py-2 text-sm font-bold rounded-full shadow-sm
                                    <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-700' : 
                                        ($ticket['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                    <?php
                                        $statusText = [
                                            'pending' => 'Menunggu',
                                            'in_progress' => 'Dikerjakan',
                                            'completed' => 'Selesai'
                                        ];
                                        echo $statusText[$ticket['status']] ?? $ticket['status'];
                                    ?>
                                </span>
                            </div>
                        </div>

                        <!-- Asset Info -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Asset yang Bermasalah</p>
                                    <p class="font-semibold text-gray-800">
                                        <i class="fas fa-laptop text-blue-500 mr-2"></i>
                                        <?= esc($ticket['asset_name']) ?>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1"><?= esc($ticket['asset_code']) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Tanggal Dibuat</p>
                                    <p class="font-semibold text-gray-800">
                                        <i class="fas fa-calendar text-green-500 mr-2"></i>
                                        <?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Tracker -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-xs text-gray-600 mb-2">
                                <span class="font-semibold">Status Progress</span>
                                <span>
                                    <?php
                                        $progressPercent = 0;
                                        if ($ticket['status'] === 'pending') $progressPercent = 33;
                                        elseif ($ticket['status'] === 'in_progress') $progressPercent = 66;
                                        else $progressPercent = 100;
                                        echo $progressPercent . '%';
                                    ?>
                                </span>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="h-3 rounded-full transition-all duration-500 <?= $ticket['status'] === 'pending' ? 'bg-red-500' : ($ticket['status'] === 'in_progress' ? 'bg-yellow-500' : 'bg-green-500') ?>" 
                                     style="width: <?= $progressPercent ?>%">
                                </div>
                            </div>
                            
                            <!-- Progress Steps -->
                            <div class="flex justify-between mt-2 text-xs">
                                <span class="<?= $ticket['status'] === 'pending' || $ticket['status'] === 'in_progress' || $ticket['status'] === 'completed' ? 'text-red-600 font-semibold' : 'text-gray-400' ?>">
                                    <i class="fas fa-circle mr-1"></i> Pending
                                </span>
                                <span class="<?= $ticket['status'] === 'in_progress' || $ticket['status'] === 'completed' ? 'text-yellow-600 font-semibold' : 'text-gray-400' ?>">
                                    <i class="fas fa-circle mr-1"></i> Dikerjakan
                                </span>
                                <span class="<?= $ticket['status'] === 'completed' ? 'text-green-600 font-semibold' : 'text-gray-400' ?>">
                                    <i class="fas fa-circle mr-1"></i> Selesai
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex gap-3">
                            <a href="<?= base_url('ticket/detail/' . $ticket['ticket_id']) ?>" 
                               class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold transition-colors shadow-md">
                                <i class="fas fa-eye mr-2"></i> Lihat Detail & Log Perbaikan
                            </a>
                            <?php if ($ticket['status'] === 'completed'): ?>
                                <button class="bg-green-100 text-green-700 px-4 py-3 rounded-lg font-semibold">
                                    <i class="fas fa-check-circle mr-2"></i> Selesai
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
             <!-- Pagination -->
        <?php if (!empty($tickets)): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                 <?= $pager->links('default', 'tailwind_pagination') ?>
            </div>
        <?php endif; ?>
    </div>
        <?php endif; ?>

    </div>

</main>

<?= view('layout/footer') ?>