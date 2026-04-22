<?php $pageTitle = 'Tìm kiếm' . (isset($keyword) && $keyword ? ': ' . $keyword : ''); ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-6xl mx-auto my-4 bg-white p-6 shadow-sm">
    <!-- Search Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-primary">
            <i class="fas fa-search mr-2 text-secondary"></i>
            <?php if (!empty($keyword)): ?>
                Kết quả tìm kiếm: "<span class="text-secondary"><?php echo htmlspecialchars($keyword); ?></span>"
            <?php else: ?>
                Tìm kiếm truyện
            <?php endif; ?>
        </h1>
        <?php if (!empty($keyword)): ?>
            <p class="text-sm text-gray-500 mt-1">Tìm thấy <strong><?php echo count($results); ?></strong> kết quả</p>
        <?php endif; ?>
    </div>

    <?php if (empty($keyword)): ?>
        <!-- Empty state: chưa nhập từ khóa -->
        <div class="text-center py-20">
            <div class="text-8xl mb-6">🔍</div>
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Nhập từ khóa để tìm kiếm</h2>
            <p class="text-gray-400">Tìm theo tên truyện, tên tác giả...</p>
            <form action="index.php" method="GET" class="mt-6 flex max-w-md mx-auto">
                <input type="hidden" name="controller" value="search">
                <input type="text" name="q" class="flex-1 h-12 px-4 border border-gray-300 rounded-l-lg focus:outline-none focus:border-primary" placeholder="Nhập tên truyện...">
                <button type="submit" class="h-12 px-6 bg-primary text-white rounded-r-lg hover:bg-purple-800 transition font-semibold">Tìm</button>
            </form>
        </div>

    <?php elseif (empty($results)): ?>
        <!-- Không có kết quả -->
        <div class="text-center py-20">
            <div class="text-8xl mb-6">😕</div>
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Không tìm thấy kết quả nào</h2>
            <p class="text-gray-400">Thử tìm với từ khóa khác hoặc kiểm tra lỗi chính tả</p>
            <a href="index.php" class="mt-4 inline-block text-primary hover:underline">← Về trang chủ</a>
        </div>

    <?php else: ?>
        <!-- Danh sách kết quả -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <?php foreach ($results as $comic): ?>
            <div class="comic-card group border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm transition-all duration-300 cursor-pointer">
                <div class="relative h-52 overflow-hidden bg-gray-100">
                    <img src="<?php echo htmlspecialchars($comic['image_url'] ?: 'https://dummyimage.com/200x250/4c2d73/ffffff&text=No+Image'); ?>"
                         alt="<?php echo htmlspecialchars($comic['name']); ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <?php if ($comic['quantity'] <= 0): ?>
                        <span class="absolute top-1 right-1 bg-gray-600 text-white text-[10px] px-1.5 py-0.5 font-bold rounded">Hết hàng</span>
                    <?php else: ?>
                        <span class="absolute top-1 right-1 bg-green-600 text-white text-[10px] px-1.5 py-0.5 font-bold rounded">Còn hàng</span>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <a href="index.php?controller=cart&action=add&id=<?php echo $comic['id']; ?>"
                           class="bg-secondary text-white font-bold py-2 px-4 rounded-xl text-sm">
                            <i class="fas fa-cart-plus mr-1"></i> Mua ngay
                        </a>
                    </div>
                </div>
                <div class="p-2">
                    <h3 class="text-sm font-medium text-gray-800 truncate hover:text-primary" title="<?php echo htmlspecialchars($comic['name']); ?>">
                        <?php echo htmlspecialchars($comic['name']); ?>
                    </h3>
                    <?php if (!empty($comic['author'])): ?>
                        <p class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($comic['author']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($comic['category_name'])): ?>
                        <span class="text-[10px] bg-purple-100 text-primary px-1.5 py-0.5 rounded mt-1 inline-block"><?php echo htmlspecialchars($comic['category_name']); ?></span>
                    <?php endif; ?>
                    <div class="font-bold text-price mt-1"><?php echo number_format($comic['price'], 0, ',', '.'); ?>đ</div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
