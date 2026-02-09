<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">
    
    <!-- Container with responsive padding -->
    <div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8 max-w-7xl">
        
        <!-- Header Section -->
        <div class="mb-6 md:mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 tracking-tight">
                        Dashboard Admin
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">
                        Selamat datang, <span class="font-semibold text-gray-800"><?= esc($user['full_name']) ?></span>
                    </p>
                </div>
                <div class="text-xs sm:text-sm text-gray-500">
                    <i class="far fa-clock mr-1"></i>
                    <span id="currentDateTime"></span>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5 mb-6 md:mb-8">
            
            <!-- Total Asset Card -->
            <div class="stat-card bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl shadow-lg p-5 lg:p-6 text-white overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider mb-1">Total Asset</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-none mb-1"><?= $total_assets ?></h3>
                            <p class="text-blue-100/80 text-xs">Hardware & Software</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-3 sm:p-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-database text-xl sm:text-2xl lg:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/20">
                        <a href="<?= base_url('asset') ?>" class="text-xs text-white/90 hover:text-white font-medium inline-flex items-center group/link">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-1 text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Total Tiket Card -->
            <div class="stat-card bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 rounded-2xl shadow-lg p-5 lg:p-6 text-white overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-amber-100 text-xs font-semibold uppercase tracking-wider mb-1">Total Tiket</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-none mb-1"><?= $total_tickets ?></h3>
                            <p class="text-amber-100/80 text-xs">Semua periode</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-3 sm:p-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-ticket-alt text-xl sm:text-2xl lg:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/20">
                        <a href="<?= base_url('ticket') ?>" class="text-xs text-white/90 hover:text-white font-medium inline-flex items-center group/link">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-1 text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Tiket Pending Card -->
            <div class="stat-card bg-gradient-to-br from-red-500 via-rose-600 to-red-700 rounded-2xl shadow-lg p-5 lg:p-6 text-white overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-red-100 text-xs font-semibold uppercase tracking-wider mb-1">Tiket Pending</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-none mb-1"><?= $ticket_by_status['pending'] ?></h3>
                            <p class="text-red-100/80 text-xs">Perlu ditindaklanjuti</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-3 sm:p-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-exclamation-circle text-xl sm:text-2xl lg:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/20">
                        <a href="<?= base_url('ticket?status=pending') ?>" class="text-xs text-white/90 hover:text-white font-medium inline-flex items-center group/link">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-1 text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Maintenance Card -->
            <div class="stat-card bg-gradient-to-br from-emerald-500 via-green-600 to-emerald-700 rounded-2xl shadow-lg p-5 lg:p-6 text-white overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider mb-1">Maintenance</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-none mb-1"><?= $maintenance_this_month ?></h3>
                            <p class="text-emerald-100/80 text-xs"><?= date('F Y') ?></p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-3 sm:p-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-wrench text-xl sm:text-2xl lg:text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/20">
                        <a href="<?= base_url('maintenance') ?>" class="text-xs text-white/90 hover:text-white font-medium inline-flex items-center group/link">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-1 text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6 mb-6 md:mb-8">
            
            <!-- Asset Status Chart -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-5 lg:p-6 border-b border-gray-100">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 flex items-center">
                        <div class="bg-blue-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-chart-pie text-blue-600"></i>
                        </div>
                        <span>Status Asset</span>
                    </h3>
                </div>
                <div class="p-5 lg:p-6">
                    <div class="relative" style="height: 280px;">
                        <canvas id="assetStatusChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Ticket Priority Chart -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-5 lg:p-6 border-b border-gray-100">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 flex items-center">
                        <div class="bg-amber-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-chart-bar text-amber-600"></i>
                        </div>
                        <span>Prioritas Tiket</span>
                    </h3>
                </div>
                <div class="p-5 lg:p-6">
                    <div class="relative" style="height: 280px;">
                        <canvas id="ticketPriorityChart"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Recent Activities Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6">
            
            <!-- Recent Tickets -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-5 lg:p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base lg:text-lg font-bold text-gray-900 flex items-center">
                            <div class="bg-amber-100 rounded-lg p-2 mr-3">
                                <i class="fas fa-ticket-alt text-amber-600"></i>
                            </div>
                            <span>Tiket Terbaru</span>
                        </h3>
                        <a href="<?= base_url('ticket') ?>" class="text-xs sm:text-sm text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200 inline-flex items-center group">
                            Lihat Semua 
                            <i class="fas fa-arrow-right ml-1 text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-5 lg:p-6">
                    <div class="space-y-3 max-h-[400px] md:max-h-[500px] overflow-y-auto custom-scrollbar">
                        <?php if (empty($recent_tickets)): ?>
                            <div class="text-center py-12">
                                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada tiket</p>
                                <p class="text-gray-400 text-sm mt-1">Tiket akan muncul di sini</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_tickets as $ticket): ?>
                                <div class="group border-l-4 <?= $ticket['priority'] === 'high' ? 'border-red-500 bg-red-50/50' : ($ticket['priority'] === 'medium' ? 'border-amber-500 bg-amber-50/50' : 'border-green-500 bg-green-50/50') ?> rounded-r-xl p-4 hover:shadow-md transition-all duration-200 cursor-pointer">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <h4 class="font-semibold text-gray-900 text-sm md:text-base flex-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                                <?= esc($ticket['title']) ?>
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full whitespace-nowrap
                                                <?= $ticket['status'] === 'pending' ? 'bg-red-500 text-white' : 
                                                    ($ticket['status'] === 'in_progress' ? 'bg-amber-500 text-white' : 'bg-green-500 text-white') ?>">
                                                <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                                            </span>
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-gray-600">
                                            <div class="inline-flex items-center">
                                                <i class="fas fa-laptop text-gray-400 mr-1.5"></i>
                                                <span class="truncate max-w-[150px] sm:max-w-none"><?= esc($ticket['asset_name']) ?></span>
                                            </div>
                                            <div class="inline-flex items-center">
                                                <i class="fas fa-user text-gray-400 mr-1.5"></i>
                                                <span class="truncate max-w-[150px] sm:max-w-none"><?= esc($ticket['reporter_name']) ?></span>
                                            </div>
                                            <div class="inline-flex items-center text-gray-500">
                                                <i class="far fa-clock text-gray-400 mr-1.5"></i>
                                                <span><?= date('d M Y', strtotime($ticket['created_at'])) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Recent Maintenance -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-5 lg:p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base lg:text-lg font-bold text-gray-900 flex items-center">
                            <div class="bg-blue-100 rounded-lg p-2 mr-3">
                                <i class="fas fa-wrench text-blue-600"></i>
                            </div>
                            <span>Maintenance Terbaru</span>
                        </h3>
                        <a href="<?= base_url('maintenance') ?>" class="text-xs sm:text-sm text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200 inline-flex items-center group">
                            Lihat Semua 
                            <i class="fas fa-arrow-right ml-1 text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-5 lg:p-6">
                    <div class="space-y-3 max-h-[400px] md:max-h-[500px] overflow-y-auto custom-scrollbar">
                        <?php if (empty($recent_maintenance)): ?>
                            <div class="text-center py-12">
                                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-tools text-gray-400 text-3xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada maintenance</p>
                                <p class="text-gray-400 text-sm mt-1">Riwayat maintenance akan muncul di sini</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_maintenance as $log): ?>
                                <div class="group border-l-4 border-blue-500 bg-blue-50/50 rounded-r-xl p-4 hover:shadow-md transition-all duration-200 cursor-pointer">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <h4 class="font-semibold text-gray-900 text-sm md:text-base flex-1 group-hover:text-blue-600 transition-colors">
                                                <?= esc($log['asset_name']) ?>
                                            </h4>
                                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                                <?= date('d M Y', strtotime($log['created_at'])) ?>
                                            </span>
                                        </div>
                                        
                                        <p class="text-xs md:text-sm text-gray-700 line-clamp-2 leading-relaxed">
                                            <?= esc($log['diagnosis']) ?>
                                        </p>
                                        
                                        <div class="flex items-center text-xs text-gray-600">
                                            <div class="bg-blue-100 rounded-full px-3 py-1 inline-flex items-center">
                                                <i class="fas fa-user-cog text-blue-600 mr-1.5"></i>
                                                <span class="font-medium truncate max-w-[150px] sm:max-w-none"><?= esc($log['technician_name']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
</main>

<!-- Custom Styles -->
<style>
/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

.stat-card {
    animation: fadeIn 0.6s ease-out;
    animation-fill-mode: both;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

/* Custom Scrollbar */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Touch-friendly tap targets for mobile */
@media (max-width: 768px) {
    button, a, .clickable {
        min-height: 44px;
        min-width: 44px;
    }
}

/* Prevent text selection on stat cards */
.stat-card {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Optimize for mobile performance */
@media (max-width: 640px) {
    .stat-card {
        will-change: transform;
    }
}
</style>

<!-- Chart.js Scripts -->
<script>
// Update current date time
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
}
updateDateTime();
setInterval(updateDateTime, 60000);

// Chart.js Configuration
Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';

// Asset Status Chart
const assetCtx = document.getElementById('assetStatusChart').getContext('2d');
const assetChart = new Chart(assetCtx, {
    type: 'doughnut',
    data: {
        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat',],
        datasets: [{
            data: [
                <?= $asset_by_status['baik'] ?>,
                <?= $asset_by_status['rusak_ringan'] ?>,
                <?= $asset_by_status['rusak_berat'] ?>,
            ],
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#ef4444',
            ],
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverOffset: 12,
            hoverBorderWidth: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: window.innerWidth < 640 ? 'bottom' : 'right',
                labels: {
                    padding: window.innerWidth < 640 ? 12 : 20,
                    font: {
                        size: window.innerWidth < 640 ? 11 : 13,
                        weight: '500'
                    },
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: window.innerWidth < 640 ? 8 : 10,
                    boxHeight: window.innerWidth < 640 ? 8 : 10
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                padding: 12,
                cornerRadius: 8,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.parsed || 0;
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%',
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    }
});

// Ticket Priority Chart
const ticketCtx = document.getElementById('ticketPriorityChart').getContext('2d');
const ticketChart = new Chart(ticketCtx, {
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
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#ef4444'
            ],
            borderRadius: 8,
            borderWidth: 0,
            hoverBackgroundColor: [
                '#059669',
                '#d97706',
                '#dc2626'
            ],
            barPercentage: 0.7,
            categoryPercentage: 0.8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: {
                        size: window.innerWidth < 640 ? 11 : 13,
                        weight: '500'
                    },
                    color: '#6b7280'
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                    drawBorder: false
                },
                border: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    font: {
                        size: window.innerWidth < 640 ? 11 : 13,
                        weight: '600'
                    },
                    color: '#374151'
                },
                border: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                padding: 12,
                cornerRadius: 8,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                displayColors: false,
                callbacks: {
                    title: function(context) {
                        return 'Prioritas: ' + context[0].label;
                    },
                    label: function(context) {
                        return 'Total: ' + context.parsed.y + ' tiket';
                    }
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    }
});

// Handle window resize
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        // Update chart legend position on mobile
        const isMobile = window.innerWidth < 640;
        
        assetChart.options.plugins.legend.position = isMobile ? 'bottom' : 'right';
        assetChart.options.plugins.legend.labels.padding = isMobile ? 12 : 20;
        assetChart.options.plugins.legend.labels.font.size = isMobile ? 11 : 13;
        assetChart.options.plugins.legend.labels.boxWidth = isMobile ? 8 : 10;
        assetChart.options.plugins.legend.labels.boxHeight = isMobile ? 8 : 10;
        
        ticketChart.options.scales.y.ticks.font.size = isMobile ? 11 : 13;
        ticketChart.options.scales.x.ticks.font.size = isMobile ? 11 : 13;
        
        assetChart.update();
        ticketChart.update();
    }, 250);
});
</script>

<?= view('layout/footer') ?>