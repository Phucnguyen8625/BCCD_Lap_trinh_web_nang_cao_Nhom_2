<?php $pageTitle = 'Quản lý truyện tranh'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kho truyện tranh</h1>
        <p class="text-sm text-slate-500">Quản lý kho hàng, giá cả và thông tin các đầu sách đang kinh doanh.</p>
    </div>
    <a href="admin.php?controller=comic&action=create" class="bg-accent hover:bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-lg shadow-indigo-200 flex items-center shrink-0">
        <i class="fas fa-plus mr-2 text-xs"></i> ĐĂNG TRUYỆN MỚI
    </a>
</div>

<!-- Product Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-4">Sản phẩm</th>
                    <th class="px-6 py-4">Phân loại</th>
                    <th class="px-6 py-4">Giá bán</th>
                    <th class="px-6 py-4 text-center">Tồn kho</th>
                    <th class="px-8 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($comics)): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">Chưa có truyện nào trong kho. Hãy bắt đầu bằng cách đăng truyện mới!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($comics as $row): ?>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-14 h-20 bg-slate-100 rounded-lg overflow-hidden shadow-sm mr-4 border border-slate-200 shrink-0 group-hover:scale-105 transition-transform">
                                    <?php if($row['image_url']): ?>
                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-[8px] text-slate-300 font-bold uppercase p-1 text-center">No Image</div>
                                    <?php endif; ?>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-800 truncate mb-1"><?php echo htmlspecialchars($row['name']); ?></p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Tác giả: <?php echo htmlspecialchars($row['author']); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter bg-slate-50 text-slate-500">
                                <?php echo htmlspecialchars($row['category_name']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-black text-slate-800"><?php echo number_format($row['price'], 0, ',', '.'); ?> <span class="text-[10px]">đ</span></p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if($row['quantity'] > 0): ?>
                                <div class="inline-flex flex-col">
                                    <span class="text-sm font-bold text-emerald-600"><?php echo $row['quantity']; ?></span>
                                    <span class="text-[8px] text-emerald-400 font-bold uppercase tracking-widest">Sẵn sàng</span>
                                </div>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-black uppercase bg-red-50 text-red-500">Hết hàng</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5 text-right space-x-1">
                            <a href="admin.php?controller=comic&action=edit&id=<?php echo $row['id']; ?>" 
                               class="inline-block p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" 
                               title="Chỉnh sửa">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <a href="admin.php?controller=comic&action=delete&id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Bạn chắc chắn muốn xóa truyện này? Thao tác không thể hoàn tác!')"
                               class="inline-block p-2 text-red-200 hover:text-red-500 hover:bg-red-50 rounded-lg transition" 
                               title="Xóa truyện">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
        <span>Tổng cộng: <?php echo count($comics); ?> đầu truyện</span>
        <span class="text-slate-300 italic font-medium lowercase">MangaStore Billing System v2.0</span>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
