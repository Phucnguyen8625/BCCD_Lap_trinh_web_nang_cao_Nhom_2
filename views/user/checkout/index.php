<?php $pageTitle = 'Thanh toán đơn hàng'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-6xl mx-auto my-8 px-4">
    <div class="flex items-center text-primary mb-8">
        <a href="index.php?controller=cart" class="hover:underline flex items-center text-sm font-medium">
            <i class="fas fa-angle-left mr-2"></i> Quay lại giỏ hàng
        </a>
        <span class="mx-4 text-gray-400">|</span>
        <h1 class="text-2xl font-bold text-gray-800 uppercase tracking-tight">Thanh toán an toàn</h1>
    </div>

    <form action="index.php?controller=checkout&action=process" method="POST">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Delivery Info -->
            <div class="w-full lg:w-2/3 space-y-6">
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-shipping-fast mr-3 text-secondary"></i> Thông tin giao hàng
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wide">Họ và tên người nhận</label>
                            <input type="text" name="name" required 
                                   value="<?php echo htmlspecialchars($currentUser['full_name'] ?? ''); ?>"
                                   class="w-full h-12 px-4 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary transition" 
                                   placeholder="Nhập họ và tên...">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wide">Số điện thoại</label>
                            <input type="text" name="phone" required 
                                   class="w-full h-12 px-4 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary transition" 
                                   placeholder="Nhập số điện thoại...">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wide">Địa chỉ Email</label>
                            <input type="email" name="email" required 
                                   value="<?php echo htmlspecialchars($currentUser['email'] ?? ''); ?>"
                                   class="w-full h-12 px-4 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary transition" 
                                   placeholder="Nhập email để nhận thông báo đơn hàng...">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wide">Địa chỉ nhận hàng chi tiết</label>
                            <textarea name="address" rows="3" required 
                                      class="w-full p-4 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary transition" 
                                      placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-wallet mr-3 text-secondary"></i> Phương thức thanh toán
                    </h2>
                    
                    <div class="space-y-3">
                        <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition peer-checked:border-primary peer-checked:bg-purple-50">
                            <input type="radio" name="payment_method" value="cod" checked class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                            <div class="ml-4 flex items-center space-x-3">
                                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Thanh toán khi nhận hàng (COD)</p>
                                    <p class="text-xs text-gray-500">Thanh toán bằng tiền mặt khi shipper giao hàng đến bạn.</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition group">
                            <input type="radio" name="payment_method" value="vnpay" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                            <div class="ml-4 flex items-center space-x-3">
                                <img src="https://sandbox.vnpayment.vn/paymentv2/Images/brands/logo-vnpay.png" class="h-6 opacity-70 group-hover:opacity-100 transition">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Thanh toán trực tuyến (VNPAY)</p>
                                    <p class="text-xs text-gray-500">Thanh toán qua ví VNPAY, thẻ ATM hoặc QR Code ngân hàng.</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white shadow-xl rounded-xl border border-gray-100 p-8 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b border-gray-50 flex items-center">
                        <i class="fas fa-box-open mr-3 text-primary opacity-30"></i> Đơn hàng của bạn
                    </h2>
                    
                    <div class="max-h-60 overflow-y-auto mb-6 pr-2 custom-scrollbar">
                        <?php foreach($cart as $item): ?>
                        <div class="flex justify-between items-start mb-4 gap-4">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800 line-clamp-1"><?php echo htmlspecialchars($item['name']); ?></p>
                                <p class="text-[10px] text-gray-400">Số lượng: <?php echo $item['quantity']; ?></p>
                            </div>
                            <span class="text-sm font-semibold text-gray-600 shrink-0">
                                <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="space-y-3 pt-6 border-t border-gray-50 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Tổng tiền hàng:</span>
                            <span class="font-bold text-gray-700"><?php echo number_format($totalAmount, 0, ',', '.'); ?>đ</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Phí vận chuyển:</span>
                            <span class="text-green-600 font-bold uppercase text-[10px]">Miễn phí</span>
                        </div>
                        <div class="flex justify-between items-end mt-4 pt-4 border-t border-dashed border-gray-100">
                            <span class="font-bold text-gray-800 uppercase text-xs tracking-widest">Tổng cộng</span>
                            <span class="font-bold text-price text-3xl"><?php echo number_format($totalAmount, 0, ',', '.'); ?><span class="text-lg">đ</span></span>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-secondary hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-xl transition shadow-xl flex items-center justify-center group">
                        ĐẶT HÀNG NGAY
                        <i class="fas fa-check-circle ml-3 group-hover:scale-110 transition-transform"></i>
                    </button>
                    
                    <div class="mt-6 p-4 bg-purple-50 rounded-lg">
                        <p class="text-[10px] text-primary font-bold text-center leading-relaxed">
                            <i class="fas fa-shield-alt mr-1"></i> MangaStore cam kết bảo mật thông tin khách hàng tuyệt đối và cung cấp phương thức thanh toán an toàn nhất.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #ccc; }
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
