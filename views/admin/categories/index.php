<?php $pageTitle = 'Quản lý danh mục'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Danh mục truyện</h1>
        <p class="text-sm text-slate-500">Phân loại thể loại truyện tranh trong cửa hàng.</p>
    </div>
    <a href="admin.php?controller=category&action=create" class="bg-accent hover:bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-lg shadow-indigo-200 flex items-center">
        <i class="fas fa-plus mr-2 text-xs"></i> THÊM DANH MỤC
    </a>
</div>

<!-- Category Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-4">ID</th>
                    <th class="px-6 py-4">Tên danh mục</th>
                    <th class="px-6 py-4 w-1/3">Mô tả</th>
                    <th class="px-6 py-4 text-center">Trạng thái</th>
                    <th class="px-8 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($categories)): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">Chưa có danh mục nào. Hãy bắt đầu bằng cách thêm mới!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($categories as $row): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 text-sm font-medium text-slate-400">#<?php echo $row['id']; ?></td>
                        <td class="px-6 py-5">
                            <span class="text-sm font-bold text-slate-800 underline decoration-indigo-200 decoration-2 underline-offset-4 hover:text-accent transition-colors"><?php echo htmlspecialchars($row['name']); ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-slate-500 line-clamp-1" title="<?php echo htmlspecialchars($row['description']); ?>">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if($row['status'] == 1): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-600">Hiển thị</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-black uppercase bg-slate-100 text-slate-400">Đang ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5 text-right space-x-2">
                            <a href="admin.php?controller=category&action=edit&id=<?php echo $row['id']; ?>" 
                               class="inline-block p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" 
                               title="Chỉnh sửa">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <a href="admin.php?controller=category&action=delete&id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Xóa danh mục này có thể ảnh hưởng đến các truyện liên quan. Bạn chắc chắn?')"
                               class="inline-block p-2 text-red-200 hover:text-red-500 hover:bg-red-50 rounded-lg transition" 
                               title="Xóa danh mục">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
        Tổng cộng: <?php echo count($categories); ?> danh mục
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
