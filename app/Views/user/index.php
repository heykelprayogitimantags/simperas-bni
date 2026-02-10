<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Kelola User</h2>
            <p class="text-gray-600 mt-1">Manajemen pengguna sistem</p>
        </div>
        <a href="<?= base_url('user/create') ?>" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
            <i class="fas fa-user-plus mr-2"></i> Tambah User
        </a>
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
                    <p class="text-blue-100 text-sm">Total User</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_users ?></h3>
                </div>
                <i class="fas fa-users text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Active</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_active ?></h3>
                </div>
                <i class="fas fa-user-check text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Admin</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_admin ?></h3>
                </div>
                <i class="fas fa-user-shield text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Teknisi</p>
                    <h3 class="text-3xl font-bold mt-1"><?= $total_teknisi ?></h3>
                </div>
                <i class="fas fa-user-cog text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form action="<?= base_url('user') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari User
                </label>
                <input 
                    type="text" 
                    name="keyword" 
                    value="<?= $keyword ?? '' ?>"
                    placeholder="Username, nama, email, atau department..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user-tag mr-1"></i> Role
                </label>
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Role</option>
                    <option value="admin" <?= ($role_filter ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="teknisi" <?= ($role_filter ?? '') === 'teknisi' ? 'selected' : '' ?>>Teknisi</option>
                    <option value="pegawai" <?= ($role_filter ?? '') === 'pegawai' ? 'selected' : '' ?>>Pegawai</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-toggle-on mr-1"></i> Status
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="1" <?= ($status_filter ?? '') === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= ($status_filter ?? '') === '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
                <a href="<?= base_url('user') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- User Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Username</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Lengkap</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Department</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-5xl mb-3 text-gray-300"></i>
                                <p class="font-medium">Tidak ada user ditemukan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded"><?= esc($u['username']) ?></span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800"><?= esc($u['full_name']) ?></td>
                                <td class="px-6 py-4 text-gray-600 text-sm"><?= esc($u['email'] ?: '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $u['role'] === 'admin' ? 'bg-purple-100 text-purple-700' : 
                                            ($u['role'] === 'teknisi' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700') ?>">
                                        <i class="fas <?= $u['role'] === 'admin' ? 'fa-user-shield' : 
                                            ($u['role'] === 'teknisi' ? 'fa-user-cog' : 'fa-user') ?> mr-1"></i>
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?= esc($u['department'] ?: '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        <?= $u['is_active'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                        <?= $u['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('user/edit/' . $u['user_id']) ?>" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('user/toggle-status/' . $u['user_id']) ?>" 
                                           class="<?= $u['is_active'] ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' ?> text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           onclick="return confirm('Yakin ingin mengubah status user ini?')"
                                           title="<?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                            <i class="fas fa-<?= $u['is_active'] ? 'ban' : 'check' ?>"></i>
                                        </a>
                                        <a href="<?= base_url('user/delete/' . $u['user_id']) ?>" 
                                           class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors"
                                           onclick="return confirmDelete('Apakah Anda yakin ingin menghapus user ini?')"
                                           title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($users)): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <?= $pager->links('default', 'tailwind_pagination') ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?= view('layout/footer') ?>