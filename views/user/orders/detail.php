<?php $pageTitle = 'Chi tiết đơn hàng #' . $order['id']; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-4xl mx-auto my-6 px-4">
    <div class="mb-4">
        <a href="index.php?controller=userorder" class="text-sm text-primary hover:underline flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Quay lại đơn hàng
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Đơn hàng #<?php echo $order['id']; ?></h1>
                <p class="text-sm text-gray-400 mt-1"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
            </div>
            <?php
            $statusMap = [
                'pending'    => ['Chờ xử lý',  'bg-yellow-100 text-yellow-700 border-yellow-300'],
                'processing' => ['Đang xử lý', 'bg-blue-100 text-blue-700 border-blue-300'],
                'completed'  => ['Hoàn thành', 'bg-green-100 text-green-700 border-green-300'],
                'cancelled'  => ['Đã hủy',     'bg-red-100 text-red-700 border-red-300'],
            ];
            $stat = $statusMap[$order['status']] ?? ['Không rõ', 'bg-gray-100 text-gray-600 border-gray-300'];
            ?>
            <span class="text-sm px-4 py-1.5 rounded-full font-semibold border <?php echo $stat[1]; ?>">
                <?php echo $stat[0]; ?>
            </span>
        </div>

        <!-- Thông tin giao hàng -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase mb-2">Thông tin người nhận</h3>
                <p class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($order['customer_phone']); ?></p>
                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($order['customer_email']); ?></p>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase mb-2">Địa chỉ giao hàng</h3>
                <p class="text-sm text-gray-700"><?php echo htmlspecialchars($order['address']); ?></p>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div>
            <h3 class="text-xs font-bold text-gray-500 uppercase mb-3">Sản phẩm đã đặt</h3>
            <div class="space-y-3">
                <?php foreach ($orderItems as $item): ?>
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <img src="<?php echo htmlspecialchars($item['image_url'] ?: 'https://dummyimage.com/60x80/4c2d73/ffffff&text=?'); ?>"
                         alt="<?php echo htmlspecialchars($item['comic_name']); ?>"
                         class="w-12 h-16 object-cover rounded">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($item['comic_name']); ?></p>
                        <?php if (!empty($item['author'])): ?>
                            <p class="text-xs text-gray-400"><?php echo htmlspecialchars($item['author']); ?></p>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-0.5">Số lượng: <?php echo $item['quantity']; ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ/quyển</p>
                        <p class="text-price font-bold"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tổng cộng -->
        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
            <div class="text-right">
                <p class="text-sm text-gray-500">Tổng tiền hàng</p>
                <p class="text-2xl font-bold text-price"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
