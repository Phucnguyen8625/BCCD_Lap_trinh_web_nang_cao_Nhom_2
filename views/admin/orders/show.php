<?php $pageTitle = 'Chi tiết đơn hàng #' . $order['id']; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="mb-8">
    <a href="admin.php?controller=order&action=index" class="text-sm font-bold text-slate-400 hover:text-accent transition flex items-center mb-4">
        <i class="fas fa-arrow-left mr-2"></i> DANH SÁCH ĐƠN HÀNG
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Details & Items -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Sản phẩm đã đặt</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                        <tr>
                            <th class="px-8 py-4">Tên truyện</th>
                            <th class="px-6 py-4">Đơn giá</th>
                            <th class="px-6 py-4 text-center">Số lượng</th>
                            <th class="px-8 py-4 text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($orderDetails as $item): ?>
                        <tr>
                            <td class="px-8 py-5 text-sm font-bold text-slate-700">
                                <?php echo htmlspecialchars($item['comic_name']); ?>
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-500">
                                <?php echo number_format($item['price'], 0, ',', '.'); ?>đ
                            </td>
                            <td class="px-6 py-5 text-center text-sm font-bold text-slate-800">
                                x<?php echo $item['quantity']; ?>
                            </td>
                            <td class="px-8 py-5 text-right text-sm font-black text-slate-800">
                                <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-slate-50/50">
                        <tr>
                            <td colspan="3" class="px-8 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-widest">Tổng tiền hàng:</td>
                            <td class="px-8 py-4 text-right text-xl font-black text-price">
                                <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fas fa-user-tag mr-3 text-accent opacity-30"></i> Thông tin khách hàng
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Họ và tên</p>
                    <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Số điện thoại</p>
                    <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($order['customer_phone']); ?></p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email</p>
                    <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($order['customer_email']); ?></p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Địa chỉ giao hàng</p>
                    <p class="text-sm font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <?php echo nl2br(htmlspecialchars($order['address'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Status Update -->
    <div class="space-y-8">
        <div class="bg-adminPrimary rounded-2xl shadow-xl p-8 text-white sticky top-8">
            <h3 class="text-lg font-bold mb-6 flex items-center">
                <i class="fas fa-tasks mr-3 text-accent"></i> Trạng thái đơn hàng
            </h3>

            <div class="mb-8">
                <?php 
                    $statusMap = [
                        'pending' => ['text-orange-400', 'Chờ xử lý', 'Đơn hàng mới chờ xác nhận'],
                        'processing' => ['text-blue-400', 'Đang giao', 'Đang vận chuyển đến khách'],
                        'completed' => ['text-emerald-400', 'Hoàn tất', 'Giao hàng thành công'],
                        'cancelled' => ['text-red-400', 'Đã hủy', 'Đơn hàng đã bị hủy bỏ']
                    ];
                    $s = $statusMap[strtolower($order['status'])] ?? ['text-slate-400', $order['status'], ''];
                ?>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Trạng thái hiện tại</p>
                <div class="flex items-center">
                    <span class="text-xl font-black uppercase <?php echo $s[0]; ?>"><?php echo $s[1]; ?></span>
                </div>
                <p class="text-xs text-slate-400 mt-1 italic"><?php echo $s[2]; ?></p>
            </div>

            <form action="admin.php?controller=order&action=updateStatus" method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 block">Cập nhật mới</label>
                    <select name="status" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition appearance-none">
                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý (Pending)</option>
                        <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý (Processing)</option>
                        <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành (Completed)</option>
                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy (Cancelled)</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-accent hover:bg-indigo-600 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-indigo-500/20">
                    LƯU THAY ĐỔI
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-800">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Lịch sử hệ thống</p>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="w-2 h-2 rounded-full bg-slate-700 mt-1.5 mr-3 shrink-0"></div>
                        <p class="text-[10px] text-slate-400 leading-relaxed italic">
                            Đơn hàng được khởi tạo tự động vào <?php echo date('H:i d/m/Y', strtotime($order['created_at'])); ?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
