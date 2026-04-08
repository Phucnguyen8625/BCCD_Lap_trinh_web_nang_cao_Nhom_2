<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Truyện - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .glass-panel { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
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
            <h2 class="text-2xl font-semibold text-gray-800">Sản Phẩm Truyện Tranh</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500">Admin Nhóm 2</span>
                <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">A</div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6 flex-1 overflow-y-auto">
            
            <?php if(isset($_GET['success'])): ?>
                <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm flex items-center">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <div class="glass-panel rounded-xl shadow-lg border-0 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <h3 class="text-lg font-semibold text-gray-700">Danh Sách Truyện Đang Bán</h3>
                    <a href="admin.php?controller=comic&action=create" class="px-5 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg flex items-center">
                        + Thêm Truyện Mới
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-medium border-b border-gray-200 w-16">Ảnh</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200">Tên Truyện</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200">Thể loại</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200">Giá Bán</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200 text-center">Tồn kho</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200 text-right">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php if(empty($comics)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Chưa có truyện nào trong giỏ. Chọn "Thêm truyện mới" để đăng bán.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($comics as $row): ?>
                                    <tr class="hover:bg-slate-50 transition duration-150 group">
                                        <td class="px-6 py-4">
                                            <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden shadow">
                                                <?php if($row['image_url']): ?>
                                                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No img</div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-indigo-600"><?php echo htmlspecialchars($row['name']); ?></div>
                                            <div class="text-xs text-gray-500 mt-1">Hãng/Tác giả: <?php echo htmlspecialchars($row['author']); ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                            <span class="bg-gray-100 text-gray-700 px-2.5 py-0.5 rounded-full text-xs">
                                                <?php echo htmlspecialchars($row['category_name']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-red-500">
                                            <?php echo number_format($row['price'], 0, ',', '.'); ?> đ
                                        </td>
                                        <td class="px-6 py-4 text-sm text-center">
                                            <?php if($row['quantity'] > 0): ?>
                                                <span class="font-semibold text-green-600"><?php echo $row['quantity']; ?> cuốn</span>
                                            <?php else: ?>
                                                <span class="font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded">Hết hàng</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right space-x-2">
                                            <a href="admin.php?controller=comic&action=edit&id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1.5 rounded-md hover:bg-indigo-100 transition">Sửa</a>
                                            <a href="admin.php?controller=comic&action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Xác nhận xóa bản ghi này?');" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1.5 rounded-md hover:bg-red-100 transition">Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
