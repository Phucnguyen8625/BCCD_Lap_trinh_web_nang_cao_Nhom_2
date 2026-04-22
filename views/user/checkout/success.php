<?php $pageTitle = 'Đặt hàng thành công'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-4xl mx-auto my-16 px-4">
    <div class="bg-white p-12 text-center shadow-xl rounded-2xl border border-gray-100">
        <div class="w-24 h-24 mx-auto mb-8 bg-green-50 rounded-full flex items-center justify-center text-green-500 shadow-inner">
            <i class="fas fa-check-circle text-5xl"></i>
        </div>
        
        <h1 class="text-3xl font-extrabold text-gray-800 mb-4 h-auto">
            <?php 
                if(isset($_GET['status']) && $_GET['status'] == 'failed') {
                    echo 'Thanh toán không thành công';
                } else {
                    echo 'Đặt hàng thành công!';
                }
            ?>
        </h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto leading-relaxed">
            <?php if(isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
                Giao dịch của bạn đã bị hủy hoặc không thành công. Đơn hàng <strong class="text-primary font-bold italic">#<?php echo htmlspecialchars($orderId); ?></strong> vẫn được lưu ở trạng thái chờ xử lý.
            <?php else: ?>
                Cảm ơn bạn đã tin tưởng MangaStore. Đơn hàng <strong class="text-primary font-bold italic">#<?php echo htmlspecialchars($orderId); ?></strong> của bạn đã được hệ thống ghi nhận và đang được xử lý.
            <?php endif; ?>
        </p>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-lg">
                <p class="text-sm text-green-700">
                    <i class="fas fa-check-circle mr-2"></i> <strong>Thành công:</strong> Thanh toán qua VNPAY đã hoàn tất.
                </p>
            </div>
        <?php elseif(isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
            <div class="mb-8 p-4 bg-red-50 border border-red-100 rounded-lg">
                <p class="text-sm text-red-700">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Lưu ý:</strong> <?php echo htmlspecialchars($message ?: 'Thanh toán chưa hoàn thành.'); ?>
                </p>
            </div>
        <?php else: ?>
            <div class="mb-8 p-6 bg-purple-50 rounded-xl inline-block max-w-sm">
                <p class="text-sm text-primary font-medium">
                    <i class="fas fa-phone-alt mr-2"></i> Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất qua số điện thoại đã cung cấp để xác nhận đơn hàng.
                </p>
            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="index.php?controller=userorder" class="w-full sm:w-auto bg-primary hover:bg-purple-800 text-white font-bold py-3.5 px-8 rounded-xl transition shadow-lg flex items-center justify-center">
                <i class="fas fa-shopping-bag mr-3"></i> XEM ĐƠN HÀNG
            </a>
            <a href="index.php" class="w-full sm:w-auto bg-white border border-gray-200 text-gray-600 hover:border-gray-400 font-bold py-3.5 px-8 rounded-xl transition flex items-center justify-center">
                TIẾP TỤC MUA SẮM
            </a>
        </div>
        
        <div class="mt-12 pt-8 border-t border-gray-50 flex justify-center items-center gap-8">
            <div class="text-center">
                <i class="fas fa-truck text-2xl text-gray-200 mb-2"></i>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Giao hàng nhanh</p>
            </div>
            <div class="text-center">
                <i class="fas fa-shield-alt text-2xl text-gray-200 mb-2"></i>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Bảo mật tuyệt đối</p>
            </div>
            <div class="text-center">
                <i class="fas fa-headset text-2xl text-gray-200 mb-2"></i>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Hỗ trợ 24/7</p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
