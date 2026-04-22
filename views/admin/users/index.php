<?php $pageTitle = 'Quản lý người dùng'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Quản lý người dùng</h1>
        <p class="text-sm text-slate-500">Danh sách tất cả khách hàng và quản trị viên trong hệ thống.</p>
    </div>
    <div class="flex space-x-3">
        <button class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition">
            <i class="fas fa-file-export mr-2"></i> Xuất Excel
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-4">Người dùng</th>
                    <th class="px-6 py-4">Tên tài khoản</th>
                    <th class="px-6 py-4">Vai trò</th>
                    <th class="px-4 py-4">Trạng thái</th>
                    <th class="px-6 py-4">Ngày tham gia</th>
                    <th class="px-8 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach($users as $user): ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']); ?>&background=random&color=fff" class="w-10 h-10 rounded-lg shadow-sm mr-4">
                            <div>
                                <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($user['full_name']); ?></p>
                                <p class="text-xs text-slate-400"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm text-slate-600 font-medium">
                        @<?php echo htmlspecialchars($user['username']); ?>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-bold <?php echo $user['role'] === 'admin' ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-50 text-slate-500'; ?>">
                            <i class="fas <?php echo $user['role'] === 'admin' ? 'fa-user-shield' : 'fa-user'; ?> mr-1.5 text-[10px]"></i>
                            <?php echo $user['role'] === 'admin' ? 'Admin' : 'User'; ?>
                        </span>
                    </td>
                    <td class="px-4 py-5 text-center">
                        <?php if($user['status'] === 'active'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-600">Hoạt động</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-black uppercase bg-red-50 text-red-600 italic">Đã khóa</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-400">
                        <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                    </td>
                    <td class="px-8 py-5 text-right space-x-2">
                        <!-- Role Toggle -->
                        <a href="admin.php?controller=user&action=toggleRole&id=<?php echo $user['id']; ?>&role=<?php echo $user['role']; ?>" 
                           class="inline-block p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" 
                           title="Đổi vai trò">
                            <i class="fas fa-user-edit text-xs"></i>
                        </a>

                        <!-- Status Toggle (Lock/Unlock) -->
                        <a href="admin.php?controller=user&action=toggleStatus&id=<?php echo $user['id']; ?>" 
                           class="inline-block p-2 <?php echo $user['status'] === 'active' ? 'text-orange-400 hover:text-orange-600 hover:bg-orange-50' : 'text-emerald-400 hover:text-emerald-600 hover:bg-emerald-50'; ?> rounded-lg transition" 
                           title="<?php echo $user['status'] === 'active' ? 'Khóa tài khoản' : 'Mở tài khoản'; ?>">
                            <i class="fas <?php echo $user['status'] === 'active' ? 'fa-lock' : 'fa-unlock'; ?> text-xs"></i>
                        </a>

                        <!-- Deletion -->
                        <a href="admin.php?controller=user&action=delete&id=<?php echo $user['id']; ?>" 
                           onclick="return confirm('Bạn có chắc muốn xóa tài khoản này? Thao tác không thể hoàn tác!')"
                           class="inline-block p-2 text-red-200 hover:text-red-500 hover:bg-red-50 rounded-lg transition" 
                           title="Xóa tài khoản">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
