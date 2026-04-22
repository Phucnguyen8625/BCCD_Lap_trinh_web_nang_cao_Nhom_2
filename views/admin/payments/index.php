<?php $pageTitle = 'Quản lý thanh toán'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Quản lý thanh toán</h1>
        <p class="text-sm text-slate-500">Đối soát giao dịch, xác nhận thanh toán thành công hoặc thất bại.</p>
    </div>
</div>

<!-- Payments Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-4">Mã GD</th>
                    <th class="px-6 py-4">Đơn hàng</th>
                    <th class="px-6 py-4">Khách hàng</th>
                    <th class="px-6 py-4">Phương thức</th>
                    <th class="px-6 py-4">Số tiền</th>
                    <th class="px-6 py-4">Cập nhật Trạng thái</th>
                    <th class="px-8 py-4 text-center">Ngày tạo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                <?php if(empty($payments)): ?>
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center text-slate-400 italic">Chưa có giao dịch thanh toán nào được ghi nhận.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($payments as $p): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 font-bold text-slate-400">#<?php echo $p['id']; ?></td>
                        <td class="px-6 py-5">
                            <a href="admin.php?controller=order&action=show&id=<?php echo $p['order_id']; ?>" class="text-indigo-600 font-bold hover:underline italic">ĐH #<?php echo $p['order_id']; ?></a>
                        </td>
                        <td class="px-6 py-5 font-bold text-slate-800">
                            <?php echo htmlspecialchars($p['customer_name']); ?>
                        </td>
                        <td class="px-6 py-5 uppercase font-black text-[10px] tracking-widest text-slate-500">
                            <?php 
                                $methods = [
                                    'cod' => 'Tiền mặt (COD)',
                                    'vnpay' => 'VNPay Online'
                                ];
                                echo $methods[strtolower($p['payment_method'])] ?? $p['payment_method']; 
                            ?>
                        </td>
                        <td class="px-6 py-5 font-black text-slate-800">
                            <?php echo number_format($p['amount'], 0, ',', '.'); ?>đ
                        </td>
                        <td class="px-6 py-5">
                            <form action="admin.php?controller=payment&action=updateStatus" method="POST" class="flex items-center space-x-2">
                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                <select name="status" class="bg-slate-50 border border-slate-200 rounded-lg text-[10px] font-bold uppercase tracking-tighter px-2 py-1 focus:outline-none focus:border-accent">
                                    <option value="pending" <?php echo $p['payment_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="success" <?php echo $p['payment_status'] == 'success' ? 'selected' : ''; ?>>Success</option>
                                    <option value="failed" <?php echo $p['payment_status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
                                </select>
                                <button type="submit" class="bg-slate-800 text-white p-1.5 rounded-lg hover:bg-slate-900 transition shadow-sm" title="Lưu">
                                    <i class="fas fa-save text-[10px]"></i>
                                </button>
                            </form>
                        </td>
                        <td class="px-8 py-5 text-center text-xs text-slate-400">
                            <?php echo date('d/m/Y H:i', strtotime($p['created_at'])); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
