<!-- Sidebar - Responsive with Mobile Toggle -->
<aside 
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white shadow-2xl lg:shadow-lg transform lg:translate-x-0 overflow-y-auto"
    style="top: 64px;"
    @click.away="if (window.innerWidth < 1024) sidebarOpen = false">
    
    <div class="p-4 lg:p-5">
        
        <!-- Mobile Close Button -->
        <div class="lg:hidden flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Menu</h3>
            <button 
                @click="sidebarOpen = false"
                class="text-gray-500 hover:text-gray-700 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Dashboard Link -->
        <a href="<?= base_url('dashboard') ?>" 
           class="flex items-center px-4 py-3 mb-2 text-gray-700 bg-orange-50 border-l-4 border-orange-500 rounded-r-lg hover:bg-orange-100 transition-all duration-200 group">
            <div class="bg-orange-100 rounded-lg p-2 mr-3 group-hover:bg-orange-200 transition-colors">
                <i class="fas fa-home text-orange-500"></i>
            </div>
            <span class="font-semibold">Dashboard</span>
        </a>
        
        <?php if ($user['role'] === 'admin'): ?>
            <!-- Admin Menu -->
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Master Data</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <a href="<?= base_url('asset') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-blue-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-blue-50 rounded-lg p-2 mr-3 group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-database text-blue-500"></i>
                    </div>
                    <span class="font-medium">Kelola Asset</span>
                </a>
                
                <a href="<?= base_url('user') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-green-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-green-50 rounded-lg p-2 mr-3 group-hover:bg-green-100 transition-colors">
                        <i class="fas fa-users text-green-500"></i>
                    </div>
                    <span class="font-medium">Kelola User</span>
                </a>
            </div>
            
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Perawatan</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <a href="<?= base_url('ticket') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-yellow-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-yellow-50 rounded-lg p-2 mr-3 group-hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-ticket-alt text-yellow-500"></i>
                    </div>
                    <span class="font-medium">Daftar Tiket</span>
                </a>
                
                <a href="<?= base_url('schedule') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-purple-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-purple-50 rounded-lg p-2 mr-3 group-hover:bg-purple-100 transition-colors">
                        <i class="fas fa-calendar-alt text-purple-500"></i>
                    </div>
                    <span class="font-medium">Jadwal Perawatan</span>
                </a>
                
                <a href="<?= base_url('maintenance') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-red-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-red-50 rounded-lg p-2 mr-3 group-hover:bg-red-100 transition-colors">
                        <i class="fas fa-wrench text-red-500"></i>
                    </div>
                    <span class="font-medium">Log Maintenance</span>
                </a>
            </div>
            
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Laporan</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <a href="<?= base_url('report') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-indigo-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-indigo-50 rounded-lg p-2 mr-3 group-hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-file-alt text-indigo-500"></i>
                    </div>
                    <span class="font-medium">Generate Laporan</span>
                </a>
            </div>
            
        <?php elseif ($user['role'] === 'teknisi'): ?>
            <!-- Teknisi Menu -->
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Pekerjaan</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <a href="<?= base_url('ticket') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-yellow-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-yellow-50 rounded-lg p-2 mr-3 group-hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-ticket-alt text-yellow-500"></i>
                    </div>
                    <span class="font-medium">Tiket Masuk</span>
                </a>
                
                <a href="<?= base_url('maintenance') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-orange-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-orange-50 rounded-lg p-2 mr-3 group-hover:bg-orange-100 transition-colors">
                        <i class="fas fa-tools text-orange-500"></i>
                    </div>
                    <span class="font-medium">Update Perbaikan</span>
                </a>
                
                <a href="<?= base_url('maintenance/history') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-blue-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-blue-50 rounded-lg p-2 mr-3 group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-history text-blue-500"></i>
                    </div>
                    <span class="font-medium">Riwayat Pekerjaan</span>
                </a>
            </div>
            
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Referensi</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <a href="<?= base_url('asset') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-gray-50 rounded-lg p-2 mr-3 group-hover:bg-gray-100 transition-colors">
                        <i class="fas fa-database text-gray-500"></i>
                    </div>
                    <span class="font-medium">Lihat Asset</span>
                </a>
                
                <a href="<?= base_url('schedule') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-purple-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-purple-50 rounded-lg p-2 mr-3 group-hover:bg-purple-100 transition-colors">
                        <i class="fas fa-calendar-alt text-purple-500"></i>
                    </div>
                    <span class="font-medium">Jadwal Perawatan</span>
                </a>
            </div>
            
        <?php else: ?>
            <!-- Pegawai Menu -->
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Layanan</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <a href="<?= base_url('ticket/create') ?>" 
                   class="flex items-center px-4 py-3 mb-3 text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg hover:from-orange-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all duration-200 group">
                    <div class="bg-white/20 rounded-lg p-2 mr-3 group-hover:bg-white/30 transition-colors">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    <span class="font-bold">Lapor Kerusakan</span>
                </a>
                
                <a href="<?= base_url('ticket/my-tickets') ?>" 
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-blue-500 rounded-r-lg transition-all duration-200 group">
                    <div class="bg-blue-50 rounded-lg p-2 mr-3 group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-list text-blue-500"></i>
                    </div>
                    <span class="font-medium">Tiket Saya</span>
                </a>
            </div>
            
            <div class="mt-6">
                <div class="flex items-center px-4 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <p class="text-xs font-bold text-gray-500 uppercase px-3">Informasi</p>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Help Section -->
        <div class="mt-8 mb-4">
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
                <div class="flex items-start">
                    <div class="bg-orange-500 rounded-lg p-2 mr-3">
                        <i class="fas fa-question-circle text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 text-sm mb-1">Butuh Bantuan?</h4>
                        <p class="text-xs text-gray-600 mb-3">Hubungi tim support kami</p>
                        <a href="<?= base_url('help') ?>" class="text-xs font-semibold text-orange-600 hover:text-orange-700 inline-flex items-center">
                            Lihat Panduan
                            <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</aside>

<!-- Mobile Overlay -->
<div 
    x-show="sidebarOpen && window.innerWidth < 1024"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
    style="top: 64px;">
</div>

<!-- Additional Sidebar Styles -->
<style>
/* Custom scrollbar for sidebar */
aside::-webkit-scrollbar {
    width: 6px;
}

aside::-webkit-scrollbar-track {
    background: #f9fafb;
}

aside::-webkit-scrollbar-thumb {
    background: #fb923c;
    border-radius: 3px;
}

aside::-webkit-scrollbar-thumb:hover {
    background: #f97316;
}

/* Smooth transitions for all sidebar links */
aside a {
    position: relative;
    overflow: hidden;
}

aside a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(251, 146, 60, 0.1), transparent);
    transition: left 0.5s;
}

aside a:hover::before {
    left: 100%;
}

/* Active link indicator */
aside a.active {
    background-color: #fff7ed;
    border-left-color: #f97316;
}

aside a.active .bg-orange-50 {
    background-color: #fed7aa;
}

/* Responsive adjustments */
@media (max-width: 1023px) {
    aside {
        max-height: calc(100vh - 64px);
    }
}
</style>

<!-- JavaScript for active link -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get current URL path
    const currentPath = window.location.pathname;
    
    // Find all sidebar links
    const sidebarLinks = document.querySelectorAll('aside a');
    
    // Add active class to current page link
    sidebarLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname;
        if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
            link.classList.add('active');
        }
    });
    
    // Close sidebar on mobile when link is clicked
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                // Trigger Alpine.js to close sidebar
                const event = new Event('click');
                document.body.dispatchEvent(event);
            }
        });
    });
});
</script>