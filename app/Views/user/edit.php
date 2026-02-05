<?= view('layout/header', ['title' => $title, 'user' => $user]) ?>
<?= view('layout/sidebar', ['user' => $user]) ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="<?= base_url('user') ?>" class="hover:text-orange-500">User</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Edit User</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">Edit User</h2>
        <p class="text-gray-600 mt-1">Perbarui informasi user: <span class="font-semibold"><?= esc($edit_user['full_name']) ?></span></p>
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
        <form action="<?= base_url('user/update/' . $edit_user['user_id']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Account Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                    Informasi Akun
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username *
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="<?= old('username', $edit_user['username']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            required
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?= old('email', $edit_user['email']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        >
                    </div>

                </div>
            </div>

            <!-- Personal Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-id-card text-green-500 mr-2"></i>
                    Informasi Personal
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap *
                        </label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            value="<?= old('full_name', $edit_user['full_name']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            required
                        >
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                            Department
                        </label>
                        <input 
                            type="text" 
                            id="department" 
                            name="department" 
                            value="<?= old('department', $edit_user['department']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        >
                    </div>

                </div>
            </div>

            <!-- Role Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user-tag text-purple-500 mr-2"></i>
                    Role & Hak Akses *
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- Admin -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition-colors">
                        <input 
                            type="radio" 
                            name="role" 
                            value="admin" 
                            class="sr-only peer"
                            <?= old('role', $edit_user['role']) === 'admin' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-purple-500 peer-checked:bg-purple-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-user-shield text-purple-500 text-2xl mr-3"></i>
                            <span class="font-semibold text-gray-800">Admin</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Full access semua fitur sistem</p>
                    </label>
                    
                    <!-- Teknisi -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                        <input 
                            type="radio" 
                            name="role" 
                            value="teknisi" 
                            class="sr-only peer"
                            <?= old('role', $edit_user['role']) === 'teknisi' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-orange-500 peer-checked:bg-orange-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-user-cog text-orange-500 text-2xl mr-3"></i>
                            <span class="font-semibold text-gray-800">Teknisi</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Handle tiket & update maintenance</p>
                    </label>
                    
                    <!-- Pegawai -->
                    <label class="relative flex flex-col p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                        <input 
                            type="radio" 
                            name="role" 
                            value="pegawai" 
                            class="sr-only peer"
                            <?= old('role', $edit_user['role']) === 'pegawai' ? 'checked' : '' ?>
                            required
                        >
                        <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 w-full h-full absolute inset-0 rounded-lg border-2"></div>
                        <div class="relative flex items-center mb-2">
                            <i class="fas fa-user text-blue-500 text-2xl mr-3"></i>
                            <span class="font-semibold text-gray-800">Pegawai</span>
                        </div>
                        <p class="relative text-xs text-gray-600">Lapor kerusakan & tracking tiket</p>
                    </label>
                    
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <a 
                    href="<?= base_url('user') ?>" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>

        </form>
    </div>

    <!-- Info Note -->
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-yellow-500 mr-2 mt-1"></i>
            <div class="text-sm text-yellow-800">
                <p class="font-semibold mb-1">Perhatian:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Kosongkan field password jika tidak ingin mengubah password</li>
                    <li>Jika mengisi password, konfirmasi password harus sama</li>
                    <li>Perubahan role akan langsung mempengaruhi hak akses user</li>
                </ul>
            </div>
        </div>
    </div>

</main>

<?= view('layout/footer') ?>