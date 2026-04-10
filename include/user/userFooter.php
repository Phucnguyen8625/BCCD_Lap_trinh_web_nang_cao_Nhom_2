<?php require_once __DIR__ . '/../../config/webConfig.php'; ?>

<footer class="bg-orange-50 border-t border-orange-100 px-6 py-10">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between gap-8">
        <div>
            <h3 class="font-bold text-xl headline text-orange-700"><?php echo e($tenWebsite); ?></h3>
            <p class="mt-2 text-[#6b3b37]">© 2026 Bản quyền thuộc về <?php echo e($tenWebsite); ?>.</p>
        </div>

        <div class="grid grid-cols-2 gap-10">
            <div>
                <h4 class="font-bold mb-3">Nền tảng</h4>
                <ul class="space-y-2 text-[#6b3b37]">
                    <li><a href="#" class="hover:text-orange-700">Điều khoản</a></li>
                    <li><a href="#" class="hover:text-orange-700">Quyền riêng tư</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-3">Hỗ trợ</h4>
                <ul class="space-y-2 text-[#6b3b37]">
                    <li><a href="#" class="hover:text-orange-700">Trợ giúp</a></li>
                    <li><a href="#" class="hover:text-orange-700">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
