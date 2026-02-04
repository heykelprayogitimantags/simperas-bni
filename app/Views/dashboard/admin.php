<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Welcome Section -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard Admin</h2>
        <p class="text-gray-600 mt-1">Selamat datang, <?= esc($user['full_name']) ?>!</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Total Assets -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Asset</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $total_assets ?></h3>
                    <p class="text-blue-100 text-xs mt-1">Hardware & Software</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-database text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Tickets -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Total Tiket</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $total_tickets ?></h3>
                    <p class="text-yellow-100 text-xs mt-1">Semua periode</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-ticket-alt text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Tickets -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Tiket Pending</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $ticket_by_status['pending'] ?></h3>
                    <p class="text-red-100 text-xs mt-1">Perlu ditindaklanjuti</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-exclamation-circle text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Maintenance This Month -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Maintenance Bulan Ini</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $maintenance_this_month ?></h3>
                    <p class="text-green-100 text-xs mt-1"><?= date('F Y') ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-wrench text-3xl"></i>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Asset Status Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                Status Asset
            </h3>
            <canvas id="assetStatusChart"></canvas>
        </div>
        
        <!-- Ticket Priority Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-yellow-500 mr-2"></i>
                Prioritas Tiket
            </h3>
            <canvas id="ticketPriorityChart"></canvas>
        </div>
        
    </div>
    
    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Tickets -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-ticket-alt text-yellow-500 mr-2"></i>
                    Tiket Terbaru
                </h3>
                <a href="<?= base_url('ticket') ?>" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-3">
                <?php if (empty($recent_tickets)): ?>
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada tiket</p>
                <?php else: ?>
                    <?php foreach ($recent_tickets as $ticket): ?>
                        <div class="border-l-4 <?= $ticket['priority'] === 'high' ? 'border-red-500' : ($ticket['priority'] === 'medium' ? 'border-yellow-500' : 'border-green-500') ?> bg-gray-50 p-3 rounded-r">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800"><?= esc($ticket['title']) ?></p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-laptop mr-1"></i> <?= esc($ticket['asset_name']) ?>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-user mr-1"></i> <?= esc($ticket['reporter_name']) ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                        <?= $ticket['status'] === 'pending' ? 'bg-red-100 text-red-700' : 
                                            ($ticket['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                        <?= ucfirst($ticket['status']) ?>
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1"><?= date('d M Y', strtotime($ticket['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Maintenance -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-wrench text-orange-500 mr-2"></i>
                    Maintenance Terbaru
                </h3>
                <a href="<?= base_url('maintenance') ?>" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-3">
                <?php if (empty($recent_maintenance)): ?>
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada maintenance</p>
                <?php else: ?>
                    <?php foreach ($recent_maintenance as $log): ?>
                        <div class="border-l-4 border-blue-500 bg-gray-50 p-3 rounded-r">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800"><?= esc($log['asset_name']) ?></p>
                                    <p class="text-sm text-gray-600 mt-1"><?= esc(substr($log['diagnosis'], 0, 60)) ?>...</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-user-cog mr-1"></i> <?= esc($log['technician_name']) ?>
                                    </p>
                                </div>
                                <div class="text-right text-xs text-gray-500">
                                    <?= date('d M Y', strtotime($log['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
    
</main>

<!-- Chart.js Scripts -->
<script>
// Asset Status Chart
const assetCtx = document.getElementById('assetStatusChart').getContext('2d');
new Chart(assetCtx, {
    type: 'doughnut',
    data: {
        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Retired'],
        datasets: [{
            data: [
                <?= $asset_by_status['baik'] ?>,
                <?= $asset_by_status['rusak_ringan'] ?>,
                <?= $asset_by_status['rusak_berat'] ?>,
                <?= $asset_by_status['retired'] ?>
            ],
            backgroundColor: ['#10b981', '#fbbf24', '#f59e0b', '#6b7280'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Ticket Priority Chart
const ticketCtx = document.getElementById('ticketPriorityChart').getContext('2d');
new Chart(ticketCtx, {
    type: 'bar',
    data: {
        labels: ['Low', 'Medium', 'High'],
        datasets: [{
            label: 'Jumlah Tiket',
            data: [
                <?= $ticket_by_priority['low'] ?>,
                <?= $ticket_by_priority['medium'] ?>,
                <?= $ticket_by_priority['high'] ?>
            ],
            backgroundColor: ['#10b981', '#fbbf24', '#ef4444'],
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

<?= view('layout/footer') ?>