<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Danh Mục - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="text-gray-800 antialiased min-h-screen flex">
    
    <!-- Sidebar Placeholder -->
    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:block">
        <div class="h-16 flex items-center justify-center border-b border-gray-800">
            <h1 class="text-xl font-bold tracking-wider text-indigo-400">COMIC ADMIN</h1>
        </div>
        <nav class="p-4 space-y-2">
            <a href="admin.php?controller=category" class="block py-2.5 px-4 rounded transition duration-200 bg-indigo-600 text-white">
                Quản lý danh mục
            </a>
            <a href="admin.php?controller=comic" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800 hover:text-white text-gray-400">Quản lý truyện bán</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <div class="flex items-center space-x-3">
                <a href="admin.php" class="text-gray-400 hover:text-indigo-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-2xl font-semibold text-gray-800">Cập Nhật Danh Mục</h2>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6 flex-1 overflow-y-auto w-full max-w-3xl mx-auto">
            
            <?php if(isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-md border-0 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Chỉnh sửa thông tin</h3>
                        <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin phân loại truyện.</p>
                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded text-sm font-medium border border-gray-200">ID: #<?php echo htmlspecialchars($this->category->id); ?></span>
                </div>
                
                <form action="admin.php?action=update" method="POST" class="p-6 space-y-6">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->category->id); ?>">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên Danh Mục <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($this->category->name); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả chi tiết</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"><?php echo htmlspecialchars($this->category->description); ?></textarea>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="status" name="status" value="1" <?php echo ($this->category->status == 1) ? 'checked' : ''; ?> class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="status" class="ml-2 block text-sm text-gray-700">
                            Hiển thị (Trạng thái hoạt động)
                        </label>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end space-x-3">
                        <a href="admin.php" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition">Hủy bỏ</a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                            Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
