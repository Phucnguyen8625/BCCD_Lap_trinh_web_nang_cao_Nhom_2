<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Truyện - Admin</title>
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
            <a href="admin.php?controller=category" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800 hover:text-white text-gray-400">
                Quản lý danh mục
            </a>
            <a href="admin.php?controller=comic" class="block py-2.5 px-4 rounded transition duration-200 bg-indigo-600 text-white">
                Quản lý truyện bán
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <div class="flex items-center space-x-3">
                <a href="admin.php?controller=comic" class="text-gray-400 hover:text-indigo-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-2xl font-semibold text-gray-800">Chỉnh Sửa Thông Tin Sản Phẩm</h2>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6 flex-1 overflow-y-auto w-full max-w-4xl mx-auto">
            
            <?php if(isset($_GET['error'])): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-md border-0 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Thông tin sản phẩm truyện</h3>
                        <p class="text-sm text-gray-500 mt-1">Cập nhật giá, kho và thông tin.</p>
                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded text-sm font-medium border border-gray-200">ID: #<?php echo htmlspecialchars($this->comic->id); ?></span>
                </div>
                
                <form action="admin.php?controller=comic&action=update" method="POST" enctype="multipart/form-data" class="p-6">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->comic->id); ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên Truyện <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($this->comic->name); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Thể loại <span class="text-red-500">*</span></label>
                                <select id="category_id" name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-white">
                                    <option value="">-- Chọn thể loại --</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $this->comic->category_id) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Tác giả</label>
                                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($this->comic->author); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả sản phẩm</label>
                                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"><?php echo htmlspecialchars($this->comic->description); ?></textarea>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                                    <input type="number" id="price" name="price" min="0" required value="<?php echo htmlspecialchars($this->comic->price); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                </div>
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Số lượng kho <span class="text-red-500">*</span></label>
                                    <input type="number" id="quantity" name="quantity" min="0" required value="<?php echo htmlspecialchars($this->comic->quantity); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                </div>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Cập nhật ảnh bìa mới (Tùy chọn)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition relative">
                                    <div class="space-y-1 text-center">
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Chọn file ảnh mới</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Bỏ trống nếu không muốn đổi ảnh bìa hiện tại</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hiển thị ảnh hiện tại nếu có -->
                            <?php if(!empty($this->comic->image_url)): ?>
                            <div class="mt-2">
                                <span class="text-sm text-gray-500">Ảnh hiện tại:</span>
                                <div class="mt-1 h-32 w-24 rounded border overflow-hidden shadow-sm">
                                    <img src="<?php echo htmlspecialchars($this->comic->image_url); ?>" alt="Current cover" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="pt-6 mt-6 border-t border-gray-100 flex justify-end space-x-3">
                        <a href="admin.php?controller=comic" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition">Hủy bỏ</a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                            Lưu Thay Đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
