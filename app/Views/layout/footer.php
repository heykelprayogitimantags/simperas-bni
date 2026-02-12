</div> <!-- End Main Content Wrapper -->
    
    <!-- Professional Footer - BNI Orange Theme -->
    <footer class="bg-gradient-to-r from-orange-500 via-orange-600 to-orange-500 border-t-4 border-orange-700 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Footer Content -->
            <div class="py-8 md:py-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Company Info -->
                    <div class="text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start mb-4">
                           <div class="bg-white rounded-lg p-2 shadow-lg flex items-center justify-center">
                                <img src="<?= base_url('Assets/images/Logo.png') ?>" 
                                    alt="Logo"
                                    class="h-6 md:h-8 w-auto object-contain">
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg">BNI</h3>
                                <p class="text-orange-100 text-xs">Bank Negara Indonesia</p>
                            </div>
                        </div>
                        <p class="text-orange-50 text-sm leading-relaxed">
                            Sistem Manajemen Perawatan Hardware & Software untuk meningkatkan efisiensi dan produktivitas IT.
                        </p>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="text-center md:text-left">
                        <h4 class="text-white font-semibold mb-4 flex items-center justify-center md:justify-start">
                            <i class="fas fa-link text-orange-200 mr-2 text-sm"></i>
                            Quick Links
                        </h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="<?= base_url('dashboard') ?>" class="text-orange-50 hover:text-white text-sm transition-colors duration-200 inline-flex items-center">
                                    <i class="fas fa-angle-right text-orange-200 mr-2 text-xs"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('asset') ?>" class="text-orange-50 hover:text-white text-sm transition-colors duration-200 inline-flex items-center">
                                    <i class="fas fa-angle-right text-orange-200 mr-2 text-xs"></i>
                                    Asset Management
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('ticket') ?>" class="text-orange-50 hover:text-white text-sm transition-colors duration-200 inline-flex items-center">
                                    <i class="fas fa-angle-right text-orange-200 mr-2 text-xs"></i>
                                    Support Tickets
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('maintenance') ?>" class="text-orange-50 hover:text-white text-sm transition-colors duration-200 inline-flex items-center">
                                    <i class="fas fa-angle-right text-orange-200 mr-2 text-xs"></i>
                                    Maintenance Log
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Support & Contact -->
                    <div class="text-center md:text-left">
                        <h4 class="text-white font-semibold mb-4 flex items-center justify-center md:justify-start">
                            <i class="fas fa-headset text-orange-200 mr-2 text-sm"></i>
                            Support & Contact
                        </h4>
                        <ul class="space-y-3">
                            <li class="flex items-center justify-center md:justify-start text-orange-50 text-sm">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2 mr-3">
                                    <i class="fas fa-phone text-white text-xs"></i>
                                </div>
                                <span>(061) 6871382</span>
                            </li>
                            <li class="flex items-center justify-center md:justify-start text-orange-50 text-sm">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2 mr-3">
                                    <i class="fas fa-envelope text-white text-xs"></i>
                                </div>
                                <span>support@bni.co.id</span>
                            </li>
                            <li class="flex items-center justify-center md:justify-start text-orange-50 text-sm">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2 mr-3">
                                    <i class="fas fa-clock text-white text-xs"></i>
                                </div>
                                <span>Sen-Jum 08:00-17:00</span>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="border-t border-orange-400 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    
                    <!-- Copyright -->
                    <div class="text-center md:text-left">
                        <p class="text-orange-50 text-sm">
                            &copy; <?= date('Y') ?> 
                            <span class="text-white font-semibold">Unit Logistics & Human Capital</span>
                        </p>
                        <p class="text-orange-200 text-xs mt-1">
                            All rights reserved. Version 1.0.0
                        </p>
                    </div>
                    
                    <!-- Social Media / Additional Info -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <a href="#" class="bg-white/20 hover:bg-white rounded-full p-2 transition-all duration-300 group backdrop-blur-sm" title="Privacy Policy">
                                <i class="fas fa-shield-alt text-white group-hover:text-orange-500 text-sm"></i>
                            </a>
                            <a href="#" class="bg-white/20 hover:bg-white rounded-full p-2 transition-all duration-300 group backdrop-blur-sm" title="Terms of Service">
                                <i class="fas fa-file-contract text-white group-hover:text-orange-500 text-sm"></i>
                            </a>
                            <a href="#" class="bg-white/20 hover:bg-white rounded-full p-2 transition-all duration-300 group backdrop-blur-sm" title="Help Center">
                                <i class="fas fa-question-circle text-white group-hover:text-orange-500 text-sm"></i>
                            </a>
                        </div>
                        
                        <!-- System Status Indicator -->
                        <div class="hidden sm:flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1.5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                            </span>
                            <span class="text-white text-xs font-medium">System Online</span>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </footer>
    
    <!-- Global Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
        
        // Confirm delete with custom styling
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
            return confirm(message);
        }
        
        // Format currency (Indonesian Rupiah)
        function formatCurrency(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }
        
        // Format date (Indonesian locale)
        function formatDate(dateString) {
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                weekday: 'long'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
        
        // Format date short
        function formatDateShort(dateString) {
            const options = { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
        
        // Time ago function
        function timeAgo(dateString) {
            const seconds = Math.floor((new Date() - new Date(dateString)) / 1000);
            
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " tahun lalu";
            
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " bulan lalu";
            
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " hari lalu";
            
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " jam lalu";
            
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " menit lalu";
            
            return Math.floor(seconds) + " detik lalu";
        }
        
        // Initialize tooltips and smooth scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
        
        // Copy to clipboard utility
        function copyToClipboard(text, message = 'Disalin ke clipboard!') {
            navigator.clipboard.writeText(text).then(function() {
                console.log(message);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
        
        // Print page utility
        function printPage() {
            window.print();
        }
        
        // Export to CSV utility
        function exportTableToCSV(filename = 'export.csv') {
            const table = document.querySelector('table');
            if (!table) return;
            
            let csv = [];
            const rows = table.querySelectorAll('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll('td, th');
                for (let j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }
                csv.push(row.join(','));
            }
            
            downloadCSV(csv.join('\n'), filename);
        }
        
        function downloadCSV(csv, filename) {
            const csvFile = new Blob([csv], { type: 'text/csv' });
            const downloadLink = document.createElement('a');
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
    
    <!-- Additional Utilities CSS -->
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Print styles */
        @media print {
            .no-print, footer, nav, .sidebar {
                display: none !important;
            }
            
            body {
                background: white !important;
            }
        }
        
        /* Loading spinner utility */
        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Pulse animation for status indicator */
        @keyframes ping {
            75%, 100% {
                transform: scale(2);
                opacity: 0;
            }
        }
        
        .animate-ping {
            animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        /* Fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Focus visible for accessibility */
        *:focus-visible {
            outline: 2px solid #fb923c;
            outline-offset: 2px;
        }
    </style>
    
</body>
</html>