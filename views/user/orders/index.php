<?php $pageTitle = 'Đơn hàng của tôi'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-4xl mx-auto my-6 px-4">
    <div class="flex gap-6">
        <!-- Sidebar -->
        <aside class="w-56 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-b from-primary to-purple-800 p-6 text-center text-white">
                    <div class="w-16 h-16 rounded-full bg-secondary flex items-center justify-center text-2xl font-bold mx-auto mb-2">
                        <?php echo mb_strtoupper(mb_substr($_SESSION['user_login']['full_name'], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                    </div>
                    <p class="font-bold text-sm"><?php echo htmlspecialchars($_SESSION['user_login']['full_name']); ?></p>
                </div>
                <div class="p-3 text-sm">
                    <a href="index.php?controller=profile" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg transition">
                        <i class="fas fa-user-cog w-4"></i> Hồ sơ cá nhân
                    </a>
                    <a href="index.php?controller=userorder" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-purple-50 text-primary font-semibold mt-1">
                        <i class="fas fa-shopping-bag w-4"></i> Đơn hàng của tôi
                    </a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="index.php?controller=auth&action=logout" class="flex items-center gap-2 px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                        <i class="fas fa-sign-out-alt w-4"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </aside>

        <!-- Orders list -->
        <div class="flex-1">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h1 class="text-xl font-bold text-gray-800 mb-5 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-primary"></i> Đơn hàng của tôi
                </h1>

                <?php if (empty($orders)): ?>
                    <div class="text-center py-16">
                        <div class="text-7xl mb-4">📦</div>
                        <h2 class="text-lg font-semibold text-gray-600 mb-2">Chưa có đơn hàng nào</h2>
                        <p class="text-gray-400 text-sm">Hãy mua sắm và đơn hàng của bạn sẽ xuất hiện tại đây</p>
                        <a href="index.php" class="mt-4 inline-block bg-primary text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-purple-800 transition">
                            Mua sắm ngay
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($orders as $order): ?>
                        <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition">
                            <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-gray-700">#<?php echo $order['id']; ?></span>
                                    <span class="text-xs text-gray-400"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></span>
                                </div>
                                <?php
                                $statusMap = [
                                    'pending'    => ['Chờ xử lý',  'bg-yellow-100 text-yellow-700'],
                                    'processing' => ['Đang xử lý', 'bg-blue-100 text-blue-700'],
                                    'completed'  => ['Hoàn thành', 'bg-green-100 text-green-700'],
                                    'cancelled'  => ['Đã hủy',     'bg-red-100 text-red-700'],
                                ];
                                $stat = $statusMap[$order['status']] ?? ['Không rõ', 'bg-gray-100 text-gray-600'];
                                ?>
                                <span class="text-xs px-2.5 py-1 rounded-full font-semibold <?php echo $stat[1]; ?>">
                                    <?php echo $stat[0]; ?>
                                </span>
                            </div>
                            <div class="px-4 py-3 flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-box mr-1 text-gray-400"></i>
                                    <?php echo $order['item_count']; ?> sản phẩm
                                    <span class="mx-2 text-gray-300">|</span>
                                    <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                    <span class="truncate" title="<?php echo htmlspecialchars($order['address']); ?>">
                                        <?php echo htmlspecialchars(mb_substr($order['address'], 0, 40) . (mb_strlen($order['address']) > 40 ? '...' : '')); ?>
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-price font-bold"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</span>
                                    <a href="index.php?controller=userorder&action=detail&id=<?php echo $order['id']; ?>"
                                       class="text-xs bg-primary text-white px-3 py-1.5 rounded-lg hover:bg-purple-800 transition font-medium">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
