<!-- Sidebar -->
<aside class="w-64 bg-white shadow-lg min-h-screen">
    <div class="p-4">
        
        <!-- Dashboard Link -->
        <a href="<?= base_url('dashboard') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
            <i class="fas fa-home mr-3 text-orange-500"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        
        <?php if ($user['role'] === 'admin'): ?>
            <!-- Admin Menu -->
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Master Data</p>
                
                <a href="<?= base_url('asset') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-database mr-3 text-blue-500"></i>
                    <span>Kelola Asset</span>
                </a>
                
                <a href="<?= base_url('user') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-users mr-3 text-green-500"></i>
                    <span>Kelola User</span>
                </a>
            </div>
            
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Perawatan</p>
                
                <a href="<?= base_url('ticket') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-ticket-alt mr-3 text-yellow-500"></i>
                    <span>Daftar Tiket</span>
                </a>
                
                <a href="<?= base_url('schedule') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                    <span>Jadwal Perawatan</span>
                </a>
                
                <a href="<?= base_url('maintenance') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-wrench mr-3 text-red-500"></i>
                    <span>Log Maintenance</span>
                </a>
            </div>
            
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Laporan</p>
                
                <a href="<?= base_url('report') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-file-alt mr-3 text-indigo-500"></i>
                    <span>Generate Laporan</span>
                </a>
            </div>
            
        <?php elseif ($user['role'] === 'teknisi'): ?>
            <!-- Teknisi Menu -->
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Pekerjaan</p>
                
                <a href="<?= base_url('ticket') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-ticket-alt mr-3 text-yellow-500"></i>
                    <span>Tiket Masuk</span>
                </a>
                
                <a href="<?= base_url('maintenance') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-tools mr-3 text-orange-500"></i>
                    <span>Update Perbaikan</span>
                </a>
                
                <a href="<?= base_url('maintenance/history') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-history mr-3 text-blue-500"></i>
                    <span>Riwayat Pekerjaan</span>
                </a>
            </div>
            
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Referensi</p>
                
                <a href="<?= base_url('asset') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-database mr-3 text-gray-500"></i>
                    <span>Lihat Asset</span>
                </a>
                
                <a href="<?= base_url('schedule') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                    <span>Jadwal Perawatan</span>
                </a>
            </div>
            
        <?php else: ?>
            <!-- Pegawai Menu -->
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Layanan</p>
                
                <a href="<?= base_url('ticket/create') ?>" class="flex items-center px-4 py-3 mb-2 text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition-colors">
                    <i class="fas fa-plus-circle mr-3"></i>
                    <span class="font-medium">Lapor Kerusakan</span>
                </a>
                
                <a href="<?= base_url('ticket/my-tickets') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-list mr-3 text-blue-500"></i>
                    <span>Tiket Saya</span>
                </a>
            </div>
            
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Informasi</p>
                
                <a href="<?= base_url('asset') ?>" class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-database mr-3 text-gray-500"></i>
                    <span>Lihat Asset</span>
                </a>
            </div>
        <?php endif; ?>
        
    </div>
</aside>