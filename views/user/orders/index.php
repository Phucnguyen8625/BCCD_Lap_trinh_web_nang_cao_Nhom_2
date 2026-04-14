<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng - MangaStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#4c2d73', secondary: '#f7941d', price: '#e53e3e', }
                }
            }
        }
    </script>
    <style> body { background-color: #ededed; font-family: 'Roboto', sans-serif; } </style>
</head>
<body class="text-gray-800">

    <!-- Top Header -->
    <header class="bg-primary pt-3 pb-3 px-4 relative" style="background-image: url('https://st.nettruyen.work/Data/Sites/1/media/bn-bg.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="index.php" class="text-3xl font-bold text-white tracking-widest pl-2" style="font-family: 'Verdana'; text-shadow: 2px 2px 0px #f7941d;">MangaStore</a>
            
            <div class="flex space-x-6 text-sm">
                <a href="index.php?controller=order" class="relative text-white flex items-center space-x-1 border-b-2 border-secondary pb-1">
                    <i class="fas fa-box text-lg text-secondary"></i>
                    <span class="ml-2 font-bold text-secondary">Đơn hàng của tôi</span>
                </a>
                <a href="index.php?controller=cart" class="relative text-white flex items-center space-x-1 hover:text-secondary transition">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="ml-2 font-medium">Giỏ hàng</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto my-8 px-4">
        <div class="flex items-center text-primary mb-6">
            <a href="index.php" class="hover:underline flex items-center text-gray-600 transition hover:text-primary"><i class="fas fa-home mr-2"></i> Trang chủ</a>
            <span class="mx-3 text-gray-400">/</span>
            <h1 class="text-2xl font-bold text-gray-800">Lịch sử đơn hàng</h1>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-semibold text-gray-700">Các đơn hàng đã đặt</h2>
                <span class="text-sm text-gray-500">Chủ tài khoản: <strong class="text-gray-800"><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
            </div>

            <?php if(empty($orders)): ?>
                <div class="p-20 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="fas fa-receipt text-4xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Bạn chưa thực hiện đơn hàng nào.</p>
                    <a href="index.php" class="inline-block bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-opacity-90 transition">Bắt đầu mua sắm</a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold">Mã Đơn</th>
                                <th class="px-6 py-4 font-bold">Ngày Đặt</th>
                                <th class="px-6 py-4 font-bold">Tổng Tiền</th>
                                <th class="px-6 py-4 font-bold">Thanh Toán</th>
                                <th class="px-6 py-4 font-bold">Trạng Thái</th>
                                <th class="px-6 py-4 font-bold text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            <?php foreach($orders as $order): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-primary">#ORD-<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td class="px-6 py-4 font-bold text-price text-base"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $order['payment_status'] == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                            <?php echo $order['payment_method']; ?> - <?php echo $order['payment_status']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php 
                                            $statusClasses = [
                                                'pending' => 'bg-gray-100 text-gray-600',
                                                'confirmed' => 'bg-blue-100 text-blue-700',
                                                'shipping' => 'bg-yellow-100 text-yellow-700',
                                                'completed' => 'bg-green-100 text-green-700',
                                                'cancelled' => 'bg-red-100 text-red-700'
                                            ];
                                            $statusText = [
                                                'pending' => 'Chờ duyệt',
                                                'confirmed' => 'Đã xác nhận',
                                                'shipping' => 'Đang giao',
                                                'completed' => 'Hoàn tất',
                                                'cancelled' => 'Đã hủy'
                                            ];
                                            $cls = $statusClasses[$order['status']] ?? 'bg-gray-100';
                                            $txt = $statusText[$order['status']] ?? $order['status'];
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?php echo $cls; ?>">
                                            <?php echo $txt; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="index.php?controller=order&action=detail&id=<?php echo $order['id']; ?>" class="bg-white border border-primary text-primary px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition shadow-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-2"></i> Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="mt-20 border-t border-gray-200 py-10 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 MangaStore. Chức năng quản lý đơn hàng dành cho Nguyễn Duy Khánh.
        </div>
    </footer>

</body>
</html>
