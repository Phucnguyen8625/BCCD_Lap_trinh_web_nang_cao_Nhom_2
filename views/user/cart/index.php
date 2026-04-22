<?php $pageTitle = 'Giỏ hàng của bạn'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-6xl mx-auto my-8 px-4">
    <div class="flex items-center text-primary mb-6">
        <a href="index.php" class="hover:underline flex items-center text-sm font-medium">
            <i class="fas fa-angle-left mr-2"></i> Tiếp tục mua hàng
        </a>
        <span class="mx-4 text-gray-400">|</span>
        <h1 class="text-2xl font-bold text-gray-800">Giỏ hàng của bạn</h1>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if(empty($cart_items)): ?>
        <div class="bg-white p-16 text-center shadow-sm rounded-xl border border-gray-100 mt-4">
            <div class="w-32 h-32 mx-auto mb-6 bg-purple-50 rounded-full flex items-center justify-center text-primary opacity-50">
                <i class="fas fa-shopping-cart text-5xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Giỏ hàng đang trống</h2>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Có vẻ như bạn chưa thêm sản phẩm nào vào giỏ hàng. Hãy khám phá kho truyện khổng lồ của chúng tôi!</p>
            <a href="index.php" class="bg-secondary text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-600 transition shadow-lg inline-block">
                KHÁM PHÁ NGAY
            </a>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                    <form action="index.php?controller=cart&action=update" method="POST">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Sản phẩm</th>
                                        <th class="px-4 py-4 font-bold text-center">Đơn giá</th>
                                        <th class="px-4 py-4 font-bold text-center">Số lượng</th>
                                        <th class="px-4 py-4 font-bold text-right">Tạm tính</th>
                                        <th class="px-4 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <?php foreach($cart_items as $item): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-6 font-medium">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-20 h-28 bg-gray-100 flex-shrink-0 rounded shadow-sm overflow-hidden">
                                                    <img src="<?php echo htmlspecialchars($item['image'] ?: 'https://dummyimage.com/80x110/4c2d73/ffffff&text=?'); ?>" 
                                                         class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-800 text-sm mb-1 hover:text-primary transition cursor-pointer"><?php echo htmlspecialchars($item['name']); ?></h3>
                                                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Mã SP: #COMIC-<?php echo $item['id']; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-6 text-center font-medium text-sm text-gray-600">
                                            <?php echo number_format($item['price'], 0, ',', '.'); ?>đ
                                        </td>
                                        <td class="px-4 py-6 text-center">
                                            <div class="inline-flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                                <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" 
                                                       class="w-16 px-2 py-1.5 text-center text-sm font-semibold focus:outline-none">
                                            </div>
                                        </td>
                                        <td class="px-4 py-6 text-right font-bold text-price text-base">
                                            <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ
                                        </td>
                                        <td class="px-4 py-6 text-center">
                                            <a href="index.php?controller=cart&action=remove&id=<?php echo $item['id']; ?>" 
                                               class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-full transition" 
                                               title="Xóa">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                            <a href="index.php" class="text-sm font-semibold text-primary hover:underline">
                                <i class="fas fa-plus mr-1 text-xs"></i> Thêm sản phẩm khác
                            </a>
                            <button type="submit" class="bg-white border border-gray-200 hover:border-primary hover:text-primary text-gray-600 py-2 px-6 rounded-lg font-bold text-sm transition shadow-sm">
                                <i class="fas fa-sync-alt mr-2 text-xs opacity-50"></i> Cập nhật giỏ hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white shadow-xl rounded-xl border border-gray-100 p-8 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b border-gray-50 flex items-center">
                        <i class="fas fa-receipt mr-3 text-primary opacity-30"></i> Tóm tắt đơn hàng
                    </h3>
                    
                    <div class="space-y-4 text-sm mb-8">
                        <div class="flex justify-between items-center text-gray-500">
                            <span>Tạm tính (<?php echo count($cart_items); ?> sản phẩm):</span>
                            <span class="font-bold text-gray-800"><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-500">
                            <span>Phí vận chuyển:</span>
                            <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-[10px] uppercase">Miễn phí</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-dashed border-gray-200 flex justify-between items-end">
                            <span class="font-bold text-gray-400 text-xs uppercase tracking-widest">Thành tiền</span>
                            <span class="font-bold text-price text-3xl"><?php echo number_format($total_price, 0, ',', '.'); ?><span class="text-lg ml-0.5">đ</span></span>
                        </div>
                    </div>
                    
                    <a href="index.php?controller=checkout" class="w-full bg-primary hover:bg-purple-800 text-white font-bold py-4 px-6 rounded-xl transition shadow-xl flex items-center justify-center group">
                        TIẾN HÀNH THANH TOÁN 
                        <i class="fas fa-arrow-right ml-3 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <div class="mt-8 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-4 font-bold">Phương thức chấp nhận</p>
                        <div class="flex justify-center items-center gap-4 text-2xl text-gray-300">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-paypal"></i>
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
