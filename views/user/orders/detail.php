<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng - MangaStore</title>
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
                <a href="index.php?controller=cart" class="relative text-white flex items-center space-x-1 hover:text-secondary transition text-gray-200">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="ml-2 font-medium">Giỏ hàng</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto my-8 px-4">
        <div class="flex items-center text-primary mb-6">
            <a href="index.php?controller=order" class="hover:underline flex items-center text-gray-600 transition hover:text-primary"><i class="fas fa-chevron-left mr-2 font-bold text-xs"></i> Lịch sử đơn hàng</a>
            <span class="mx-3 text-gray-400">/</span>
            <h1 class="text-2xl font-bold text-gray-800">Chi tiết đơn hàng #<?php echo str_pad($this->orderModel->id, 6, '0', STR_PAD_LEFT); ?></h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Order Status & Summary -->
            <div class="md:col-span-2 space-y-6">
                <!-- Status Bar -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Trạng thái đơn hàng</p>
                            <?php 
                                $statusText = [
                                    'pending' => 'Đang chờ xử lý',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipping' => 'Đang vận chuyển',
                                    'completed' => 'Giao hàng thành công',
                                    'cancelled' => 'Đã hủy đơn'
                                ];
                                $st = $this->orderModel->status;
                            ?>
                            <h3 class="text-lg font-bold text-primary"><?php echo $statusText[$st] ?? $st; ?></h3>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Ngày đặt hàng</p>
                            <p class="font-medium"><?php echo date('d M, Y H:i', strtotime($this->orderModel->created_at)); ?></p>
                        </div>
                    </div>

                    <!-- Progress Line (Mockup representation) -->
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div class="flex space-x-2">
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                    Tiến độ
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-blue-600">
                                    <?php 
                                        $progress = ['pending' => '20%', 'confirmed' => '50%', 'shipping' => '80%', 'completed' => '100%', 'cancelled' => '0%'];
                                        echo $progress[$st] ?? '10%';
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-100">
                            <div style="width:<?php echo $progress[$st] ?? '10%'; ?>" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary"></div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700">Sản phẩm trong đơn</div>
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach($items as $item): ?>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-16 bg-gray-100 rounded-md overflow-hidden flex-shrink-0 border border-gray-200">
                                                <img src="https://via.placeholder.com/200x250/2c5282/ffffff?text=Comic" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($item['comic_name']); ?></p>
                                                <p class="text-xs text-gray-500">Số lượng: <?php echo $item['quantity']; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <p class="text-xs text-gray-400 font-medium">Đơn giá: <?php echo number_format($item['price'], 0, ',', '.'); ?>đ</p>
                                        <p class="font-bold font-sm text-price"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="bg-gray-50/50 p-6 flex justify-between items-center border-t border-gray-100">
                        <span class="font-bold text-gray-600 uppercase text-xs tracking-widest">Tổng cộng</span>
                        <span class="text-2xl font-bold text-price"><?php echo number_format($this->orderModel->total_amount, 0, ',', '.'); ?>đ</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Receiver info -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-3 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-primary"></i> Thông tin nhận hàng
                    </h3>
                    <div class="space-y-3 text-sm">
                        <p><span class="text-gray-500 block text-xs">Họ tên:</span> <strong class="text-gray-800"><?php echo htmlspecialchars($this->orderModel->receiver_name); ?></strong></p>
                        <p><span class="text-gray-500 block text-xs">Điện thoại:</span> <strong class="text-gray-800"><?php echo htmlspecialchars($this->orderModel->phone); ?></strong></p>
                        <p><span class="text-gray-500 block text-xs">Địa chỉ:</span> <span class="text-gray-700 leading-relaxed"><?php echo htmlspecialchars($this->orderModel->address); ?></span></p>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-3 mb-4 flex items-center">
                        <i class="fas fa-credit-card mr-2 text-primary"></i> Thanh toán
                    </h3>
                    <div class="space-y-3 text-sm">
                        <p><span class="text-gray-500 block text-xs">Phương thức:</span> <strong class="text-gray-800"><?php echo $this->orderModel->payment_method; ?></strong></p>
                        <p><span class="text-gray-500 block text-xs">Trạng thái:</span> 
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase <?php echo $this->orderModel->payment_status == 'paid' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'; ?>">
                                <?php echo $this->orderModel->payment_status; ?>
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Note -->
                <?php if(!empty($this->orderModel->note)): ?>
                <div class="bg-yellow-50 p-6 rounded-xl shadow-sm border border-yellow-200">
                    <h3 class="text-xs font-bold text-yellow-800 uppercase tracking-widest mb-2 flex items-center">
                        <i class="fas fa-sticky-note mr-2 text-yellow-600"></i> Ghi chú
                    </h3>
                    <p class="text-xs text-yellow-700 italic leading-relaxed"><?php echo htmlspecialchars($this->orderModel->note); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="mt-20 border-t border-gray-200 py-10 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 MangaStore. Phát triển bởi Nguyễn Duy Khánh.
        </div>
    </footer>

</body>
</html>
