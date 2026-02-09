<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Generate Laporan</h2>
        <p class="text-gray-600 mt-1">Export laporan ke PDF atau Excel</p>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Asset</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_assets ?></h3>
                </div>
                <i class="fas fa-database text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">Total Tiket</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_tickets ?></h3>
                </div>
                <i class="fas fa-ticket-alt text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Maintenance</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_maintenance ?></h3>
                </div>
                <i class="fas fa-wrench text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total User</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_users ?></h3>
                </div>
                <i class="fas fa-users text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Report Types -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Asset Report -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Laporan Asset</h3>
                    <i class="fas fa-database text-3xl opacity-75"></i>
                </div>
                <p class="text-blue-100 text-sm">Export data semua asset hardware & software</p>
            </div>
            
            <div class="p-6">
                <form id="assetReportForm" action="<?= base_url('report/assets') ?>" method="GET" target="_blank">
                    
                    <!-- Type Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Asset</label>
                        <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                            <option value="retired">Retired</option>
                        </select>
                    </div>
                    
                    <!-- Format Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="pdf" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-file-pdf mr-2"></i> PDF
                            </button>
                            <button type="submit" name="format" value="excel" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-file-excel mr-2"></i> Excel
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>

        <!-- Maintenance Report -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Laporan Maintenance</h3>
                    <i class="fas fa-wrench text-3xl opacity-75"></i>
                </div>
                <p class="text-orange-100 text-sm">Export riwayat perbaikan & perawatan</p>
            </div>
            
            <div class="p-6">
                <form action="<?= base_url('report/maintenance') ?>" method="GET" target="_blank">
                    
                    <!-- Date Range -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500" placeholder="Dari">
                            <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500" placeholder="Sampai">
                        </div>
                    </div>
                    
                    <!-- Technician Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teknisi</label>
                        <select name="technician_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="">Semua Teknisi</option>
                            <!-- Will be populated from database -->
                        </select>
                    </div>
                    
                    <!-- Format Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="pdf" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-file-pdf mr-2"></i> PDF
                            </button>
                            <button type="submit" name="format" value="excel" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-file-excel mr-2"></i> Excel
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>

        <!-- Ticket Report -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Laporan Tiket</h3>
                    <i class="fas fa-ticket-alt text-3xl opacity-75"></i>
                </div>
                <p class="text-yellow-100 text-sm">Export data laporan kerusakan</p>
            </div>
            
            <div class="p-6">
                <form action="<?= base_url('report/tickets') ?>" method="GET" target="_blank">
                    
                    <!-- Date Range -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500" placeholder="Dari">
                            <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500" placeholder="Sampai">
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    
                    <!-- Priority Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                        <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                            <option value="">Semua Prioritas</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    
                    <!-- Format Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="pdf" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-file-pdf mr-2"></i> PDF
                            </button>
                            <button type="submit" name="format" value="excel" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-file-excel mr-2"></i> Excel
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>

    </div>

    <!-- Info Note -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Catatan:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>PDF:</strong> Format untuk dicetak atau dibaca langsung</li>
                    <li><strong>Excel:</strong> Format untuk diolah lebih lanjut (pivot, chart, dll)</li>
                    <li>Filter yang tidak diisi akan mengambil semua data</li>
                    <li>Untuk periode kosong, akan mengambil data 1 bulan terakhir</li>
                    <li>File akan otomatis ter-download setelah generate</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<?= view('layout/footer') ?>