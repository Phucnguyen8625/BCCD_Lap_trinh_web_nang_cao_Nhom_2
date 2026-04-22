<?php $pageTitle = 'Quản lý đơn hàng'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Quản lý đơn hàng</h1>
        <p class="text-sm text-slate-500">Theo dõi, kiểm tra và cập nhật trạng thái đơn hàng của khách hàng.</p>
    </div>
</div>

<!-- Order Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-4">Mã đơn</th>
                    <th class="px-6 py-4">Khách hàng</th>
                    <th class="px-6 py-4">Tổng số tiền</th>
                    <th class="px-6 py-4">Trạng thái</th>
                    <th class="px-6 py-4 text-center">Ngày đặt</th>
                    <th class="px-8 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($orders)): ?>
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-400 italic">Chưa có đơn hàng nào được đặt.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($orders as $o): ?>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg italic">#<?php echo $o['id']; ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($o['customer_name']); ?></p>
                            <p class="text-[10px] text-slate-400 font-bold"><?php echo htmlspecialchars($o['customer_phone']); ?></p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-black text-slate-800"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</p>
                        </td>
                        <td class="px-6 py-5">
                            <?php 
                                $statusMap = [
                                    'pending' => ['bg-orange-50', 'text-orange-600', 'Chờ xử lý'],
                                    'processing' => ['bg-blue-50', 'text-blue-600', 'Đang giao'],
                                    'completed' => ['bg-emerald-50', 'text-emerald-600', 'Hoàn tất'],
                                    'cancelled' => ['bg-red-50', 'text-red-600', 'Đã hủy']
                                ];
                                $s = $statusMap[strtolower($o['status'])] ?? ['bg-slate-50', 'text-slate-400', $o['status']];
                            ?>
                            <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest <?php echo $s[0] . ' ' . $s[1]; ?>">
                                <?php echo $s[2]; ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center text-xs text-slate-400">
                            <?php echo date('d/m/Y H:i', strtotime($o['created_at'])); ?>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="admin.php?controller=order&action=show&id=<?php echo $o['id']; ?>" 
                               class="bg-white border border-slate-200 text-slate-600 hover:text-accent hover:border-accent text-xs font-bold py-2 px-4 rounded-xl transition shadow-sm">
                                CHI TIẾT
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
