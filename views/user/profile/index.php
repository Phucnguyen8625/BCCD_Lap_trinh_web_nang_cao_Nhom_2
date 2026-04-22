<?php $pageTitle = 'Hồ sơ cá nhân'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-4xl mx-auto my-6 px-4">
    <div class="flex gap-6">
        <!-- Sidebar Profile -->
        <aside class="w-56 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-b from-primary to-purple-800 p-6 text-center text-white">
                    <div class="w-20 h-20 rounded-full bg-secondary flex items-center justify-center text-3xl font-bold mx-auto mb-3">
                        <?php echo mb_strtoupper(mb_substr($user['full_name'], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                    </div>
                    <p class="font-bold text-sm"><?php echo htmlspecialchars($user['full_name']); ?></p>
                    <p class="text-xs text-purple-200 mt-0.5">@<?php echo htmlspecialchars($user['username']); ?></p>
                    <span class="mt-2 inline-block text-[10px] bg-secondary px-2 py-0.5 rounded-full font-semibold">
                        <?php echo $user['role'] === 'admin' ? 'Admin' : 'Thành viên'; ?>
                    </span>
                </div>
                <div class="p-3 text-sm">
                    <a href="index.php?controller=profile" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-purple-50 text-primary font-semibold">
                        <i class="fas fa-user-cog w-4"></i> Hồ sơ cá nhân
                    </a>
                    <a href="index.php?controller=userorder" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg mt-1 transition">
                        <i class="fas fa-shopping-bag w-4"></i> Đơn hàng của tôi
                    </a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="index.php?controller=auth&action=logout" class="flex items-center gap-2 px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                        <i class="fas fa-sign-out-alt w-4"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 space-y-5">
            <?php if (!empty($message)): ?>
                <div class="px-4 py-3 rounded-lg text-sm font-medium
                    <?php echo $messageType === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                    <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Thông tin cơ bản -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-id-card text-primary"></i> Thông tin cá nhân
                </h2>
                <form method="POST" action="index.php?controller=profile" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Họ và tên</label>
                            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>"
                                   class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tên đăng nhập</label>
                            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>"
                                   class="w-full h-10 px-3 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-400" readonly>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                                   class="w-full h-10 px-3 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-400" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ngày tham gia</label>
                            <input type="text" value="<?php echo date('d/m/Y', strtotime($user['created_at'])); ?>"
                                   class="w-full h-10 px-3 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-400" readonly>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-purple-800 transition">
                            <i class="fas fa-save mr-2"></i>Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-lock text-secondary"></i> Đổi mật khẩu
                </h2>
                <form method="POST" action="index.php?controller=profile" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Mật khẩu cũ</label>
                        <input type="password" name="old_password" class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary" placeholder="Nhập mật khẩu hiện tại...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary" placeholder="Tối thiểu 6 ký tự...">
                    </div>
                    <button type="submit" class="bg-secondary text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-orange-500 transition">
                        <i class="fas fa-key mr-2"></i>Đổi mật khẩu
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
