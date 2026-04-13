<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Danh Mục Truyện - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
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
            <a href="admin.php?controller=comic" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800 hover:text-white text-gray-400">
                Quản lý truyện bán
            </a>
            <!-- Các menu khác -->
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <h2 class="text-2xl font-semibold text-gray-800">Danh Mục Truyện</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500">Admin Nhóm 2</span>
                <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">A</div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6 flex-1 overflow-y-auto">
            
            <?php if(isset($_GET['success'])): ?>
                <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <div class="glass-panel rounded-xl shadow-lg border-0 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <h3 class="text-lg font-semibold text-gray-700">Danh Sách Phân Loại Thể Loại Truyện</h3>
                    <a href="admin.php?action=create" class="px-5 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Thêm danh mục mới
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-medium border-b border-gray-200">ID</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200">Tên Danh Mục</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200">Mô Tả</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200">Trạng Thái</th>
                                <th class="px-6 py-4 font-medium border-b border-gray-200 text-right">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php if(empty($categories)): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Chưa có danh mục nào. Hãy thêm mới!</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($categories as $row): ?>
                                    <tr class="hover:bg-slate-50 transition duration-150 group">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#<?php echo $row['id']; ?></td>
                                        <td class="px-6 py-4 text-sm font-semibold text-indigo-600"><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs"><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td class="px-6 py-4 text-sm">
                                            <?php if($row['status'] == 1): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    Hoạt động
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    Đang ẩn
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right space-x-3">
                                            <a href="admin.php?action=edit&id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1.5 rounded-md hover:bg-indigo-100 transition">Sửa</a>
                                            <a href="admin.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1.5 rounded-md hover:bg-red-100 transition">Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                    <p>Tổng cộng: <span class="font-semibold text-gray-700"><?php echo count($categories); ?></span> danh mục.</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
