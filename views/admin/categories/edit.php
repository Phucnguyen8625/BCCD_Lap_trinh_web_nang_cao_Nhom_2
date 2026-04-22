<?php $pageTitle = 'Sửa danh mục: ' . $this->category->name; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="mb-8">
    <a href="admin.php?controller=category&action=index" class="text-sm font-bold text-slate-400 hover:text-accent transition flex items-center mb-4">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> DANH SÁCH DANH MỤC
    </a>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Sửa danh mục</h1>
        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold border border-slate-200 uppercase tracking-tighter italic">ID: #<?php echo htmlspecialchars($this->category->id); ?></span>
    </div>
</div>

<div class="max-w-2xl">
    <form action="admin.php?controller=category&action=update" method="POST" class="space-y-8">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->category->id); ?>">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center">
                <div class="w-8 h-8 bg-accent/10 text-accent rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Cập nhật thông tin</h3>
            </div>
            
            <div class="p-8 space-y-6">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Tên Danh Mục <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($this->category->name); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Ví dụ: Hành động, Tình cảm...">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Mô tả thể loại</label>
                    <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Mô tả tóm tắt về thể loại này..."><?php echo htmlspecialchars($this->category->description); ?></textarea>
                </div>

                <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <input type="checkbox" id="status" name="status" value="1" <?php echo ($this->category->status == 1) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-slate-300 text-accent focus:ring-accent transition cursor-pointer">
                    <label for="status" class="text-sm font-bold text-slate-600 cursor-pointer uppercase tracking-tighter">Hiển thị trên website</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="admin.php?controller=category" class="px-8 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-slate-600 transition">HỦY BỎ</a>
            <button type="submit" class="bg-accent hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-xl transition shadow-xl shadow-indigo-200">
                LƯU THAY ĐỔI
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
