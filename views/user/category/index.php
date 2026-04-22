<?php $pageTitle = isset($currentCategory) && $currentCategory ? htmlspecialchars($currentCategory['name']) : 'Danh mục truyện'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-6xl mx-auto my-4 shadow-sm">
    <div class="flex gap-4">
        <!-- Sidebar: danh sách danh mục -->
        <aside class="w-52 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-primary text-white px-4 py-3 font-bold text-sm uppercase tracking-wide">
                    <i class="fas fa-list mr-2"></i>Danh mục
                </div>
                <?php foreach ($categories as $cat): ?>
                    <a href="index.php?controller=category&id=<?php echo $cat['id']; ?>"
                       class="flex items-center px-4 py-2.5 text-sm border-b border-gray-50 transition
                              <?php echo (isset($currentCategory) && $currentCategory['id'] == $cat['id']) ? 'bg-purple-50 text-primary font-semibold border-l-4 border-l-primary' : 'text-gray-700 hover:bg-gray-50 hover:text-primary'; ?>">
                        <i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 bg-white rounded-lg shadow-sm p-5">
            <?php if ($currentCategory): ?>
                <div class="flex items-center justify-between mb-5 border-b-2 border-primary pb-3">
                    <h1 class="text-xl font-bold text-primary uppercase">
                        <i class="fas fa-book-open mr-2 text-secondary"></i>
                        <?php echo htmlspecialchars($currentCategory['name']); ?>
                    </h1>
                    <span class="text-sm text-gray-400"><?php echo count($comics); ?> truyện</span>
                </div>

                <?php if (empty($comics)): ?>
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📚</div>
                        <p class="text-gray-500">Chưa có truyện nào trong danh mục này.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php foreach ($comics as $comic): ?>
                        <div class="comic-card group border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 cursor-pointer">
                            <div class="relative h-52 bg-gray-100 overflow-hidden">
                                <img src="<?php echo htmlspecialchars($comic['image_url'] ?: 'https://dummyimage.com/200x250/4c2d73/ffffff&text=No+Image'); ?>"
                                     alt="<?php echo htmlspecialchars($comic['name']); ?>"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <?php if ($comic['quantity'] <= 0): ?>
                                    <span class="absolute top-1 right-1 bg-gray-600 text-white text-[10px] px-1.5 py-0.5 rounded font-bold">Hết hàng</span>
                                <?php else: ?>
                                    <span class="absolute top-1 right-1 bg-green-600 text-white text-[10px] px-1.5 py-0.5 rounded font-bold">Còn hàng</span>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <a href="index.php?controller=cart&action=add&id=<?php echo $comic['id']; ?>"
                                       class="bg-secondary text-white font-bold py-2 px-3 rounded-lg text-sm">
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
                                <div class="font-bold text-price mt-1"><?php echo number_format($comic['price'], 0, ',', '.'); ?>đ</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Chưa chọn danh mục -->
                <div class="text-center py-20">
                    <div class="text-7xl mb-6">📖</div>
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">Chọn một danh mục</h2>
                    <p class="text-gray-400">Chọn danh mục bên trái để xem các truyện trong thể loại đó</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
