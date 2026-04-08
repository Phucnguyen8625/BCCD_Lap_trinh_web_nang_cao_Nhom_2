<?php
$pageTitle = 'Trang chủ - Mực Chuyển Động';
require_once __DIR__ . '/../config/WebConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('kiemTraDangNhapNguoiDung')) {
    function kiemTraDangNhapNguoiDung(): bool
    {
        return !empty($_SESSION['user_logged_in']) || !empty($_SESSION['user']);
    }
}

if (!function_exists('layTenNguoiDung')) {
    function layTenNguoiDung(): string
    {
        if (!empty($_SESSION['user_name'])) {
            return (string) $_SESSION['user_name'];
        }

        if (!empty($_SESSION['user']['name'])) {
            return (string) $_SESSION['user']['name'];
        }

        return 'Bạn đọc';
    }
}

if (!kiemTraDangNhapNguoiDung()) {
    header('Location: ' . (defined('PUBLIC_URL') ? PUBLIC_URL . '/Login.php' : 'Login.php'));
    exit;
}

$thongBao = '';
$tenNguoiDung = layTenNguoiDung();
$tuTruyen = $_SESSION['user_library'] ?? [];

$truyenNoiBat = [
    [
        'id' => 1,
        'ten' => 'Neon Drifters',
        'gia' => '119.000đ',
        'theLoai' => 'Khoa học viễn tưởng',
        'moTa' => 'Một hành trình xuyên thành phố ánh sáng cùng nhóm thợ săn ký ức.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAes87Fv5ozt2posbJn-K-iVS9kdI2gA2w2VgU12Fe-acGIm64WMFPwzCIQBCOXXHCGAI6Oj0rAlEVV6rgi3aG9j4ov6n2Y_9aSsHW55sZOiW6C2KIrKdnCOkAQ0-qPFLC7n8hT6zPmvo1-OEqDJspIBPIcdklGrs_83aD9K5lHfaHnGKIywWPmU6m7ASG9dVMNFvrG9S_1Fqd_SZuVT3qMURikJNjtdnhQ5Ag9Q-tvua32LaBzVcuAxMtbZ5HiThKDjsdboPIMwmaH',
    ],
    [
        'id' => 2,
        'ten' => 'The Ember King',
        'gia' => '299.000đ',
        'theLoai' => 'Kỳ ảo',
        'moTa' => 'Cuộc chiến ngai vàng giữa tro tàn, lửa thiêng và lời nguyền cổ.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAF4Z1YV7iRpcusut8Rxv0dI4RD77Cn1IjLEmka9811sO_PhaOFRftDDPtxKaVLbunOeHaH-JLxN_Xx1Q5B-sF_IgPNw9lLLH3o4jeyEbcVQ-gOHXMhuLQ9LFUttFO1EzGBq4dsw4i3DlMJqSD3AnQwqY0hHCK9QAaszs0iWov-70pTJ9-9bl8uZ9cSqFlQ0rVI_WJoQrTHaUTaIyU_tWRV8FqFfuxDaMhtlvFd-2IMt2nL5qoLwQZcrg08IDuG79KUkaJ60BFcOYVE',
    ],
    [
        'id' => 3,
        'ten' => 'Moss & Moonlight',
        'gia' => '79.000đ',
        'theLoai' => 'Phiêu lưu',
        'moTa' => 'Một khu rừng biết nói và cô gái giữ bí mật của mặt trăng.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB2Pa5W0ejbol_UBuCHJF7Qj3nlV1kYH-_GsI-iVNaUaCDfcbsG-ZkvH0gs7Rx3Cm44Br1TpnzU8DEnYhzbnlPzmxAjK6p3D8yXyq46WkTPVKOjdYb5hi1hQqZrhwUU7c0x4hoi9HZ0pmilhJS43jtSUmi6z0QkV42xRH-oBnbG9bQCKoSxMu95pOcDGBkZ1dw6Pn0TwUo77VuIYoKsVoo569KaAo6d78hn4K-P6sWpiaLiL6Bh7C1jm8DQzMjNOFOf_XOuCCcGZpWL',
    ],
    [
        'id' => 4,
        'ten' => 'Void Voyager',
        'gia' => '99.000đ',
        'theLoai' => 'Hành động',
        'moTa' => 'Phi hành đoàn lạc vào vùng không gian nơi ký ức biến thành sinh vật.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBcQd0sG7zY_KKVmwvpnlIylcPEVxNZGetOKUj8jU4Wah3FTAvriKUnSOoXgCwhW5gBQbubBPUMRodAvxupTpzstCPBwxjS3u62QVmZdHvCN1ShREVEDKQchmjJlFc3uBbzg4nxI0KmYgt9aj4VPtqZB3At7hIt9R9wYJE9L-4lZ18jzJ7yGrLhi6_DTxgnYqR53uFoftebq2RNqBmYz8PbreOHzc5K2qMy6U-UEf2bSmYCeHEWqiajJlCgPXU0SuHNq2y_efRi6_jL',
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $thongBao = 'Vui lòng nhập email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $thongBao = 'Email không đúng định dạng.';
    } else {
        $thongBao = 'Đăng ký nhận tin thành công cho email: ' . e($email);
    }
}

require_once __DIR__ . '/../include/user/UserHeader.php';
?>

<link rel="stylesheet" href="../assets/css/public/index.css">

<section class="home-hero section-spacing">
    <div class="container hero-grid">
        <div class="hero-content">
            <p class="hello-badge">
                Xin chào <?php echo e($tenNguoiDung); ?>
            </p>

            <h1 class="headline hero-title">
                Không gian đọc truyện dành riêng cho bạn
            </h1>

            <p class="hero-desc">
                Khám phá truyện mới, đọc tiếp chương đang dở, lưu tác phẩm yêu thích vào tủ truyện và theo dõi thị trường truyện số trong cùng một giao diện thống nhất.
            </p>

            <div class="stats-grid">
                <div class="stat-card">
                    <p class="stat-label">Tủ truyện hiện có</p>
                    <p class="stat-value"><?php echo count($tuTruyen); ?></p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Trang cần ghé</p>
                    <p class="stat-value">5</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Ưu đãi hôm nay</p>
                    <p class="stat-value">3</p>
                </div>
            </div>

            <div class="hero-actions">
                <a href="<?php echo PUBLIC_URL; ?>/Library.php" class="btn btn-gradient">
                    Vào thư viện
                </a>
                <a href="<?php echo PUBLIC_URL; ?>/StoryMarket.php" class="btn btn-blue">
                    Xem chợ truyện
                </a>
                <a href="<?php echo PUBLIC_URL; ?>/List.php" class="btn btn-orange-soft">
                    Tủ truyện của tôi
                </a>
            </div>
        </div>

        <div class="hero-image-wrap">
            <img
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDbbuoMLfIBiupnJwA9lNAIBE_296PAcIYKzwY5KR4wptJxCBaPnThnj410DP4fTXKmOrSUzYXpOnJmrNdIRfoi1Ryo9X2h3W_XISgZWCQ1j--8gAkZRYkfPWgH_6nDSg4KiqxRCBCWeu4lj7o1PuXWn3e8GJzYNnfCaN2qzMkA9SF5NYyOet53XalNTFZiH4s1Ch_U5rfC5tIZjmjNap-R-fvxwjcfRvsMHXol9PLiGvqlEjf4wVeFoS2g8KWUp_vhqYDX-FZR-V43"
                alt="Ảnh bìa chính"
                class="hero-image"
            >
        </div>
    </div>
</section>

<section class="featured-section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="headline section-title">Truyện nổi bật</h2>
                <p class="section-subtitle">Những tác phẩm phù hợp để bắt đầu hành trình đọc ngay hôm nay.</p>
            </div>

            <a href="<?php echo PUBLIC_URL; ?>/Library.php" class="section-link">
                Xem tất cả
            </a>
        </div>

        <div class="featured-grid">
            <?php foreach ($truyenNoiBat as $truyen): ?>
                <div class="story-card">
                    <img
                        src="<?php echo e($truyen['anh']); ?>"
                        alt="<?php echo e($truyen['ten']); ?>"
                        class="story-image"
                    >

                    <div class="story-body">
                        <span class="story-tag">
                            <?php echo e($truyen['theLoai']); ?>
                        </span>
                        <h3 class="story-title"><?php echo e($truyen['ten']); ?></h3>
                        <p class="story-desc"><?php echo e($truyen['moTa']); ?></p>
                        <p class="story-price"><?php echo e($truyen['gia']); ?></p>

                        <div class="story-actions">
                            <a href="<?php echo PUBLIC_URL; ?>/Main.php?id=<?php echo (int) $truyen['id']; ?>" class="story-btn story-btn-primary">
                                Xem truyện
                            </a>
                            <a href="<?php echo PUBLIC_URL; ?>/List.php?add=<?php echo (int) $truyen['id']; ?>" class="story-btn story-btn-secondary">
                                Lưu
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="quick-links-section section-spacing">
    <div class="container quick-links-grid">
        <a href="<?php echo PUBLIC_URL; ?>/Library.php" class="quick-card">
            <h3 class="headline quick-card-title">Thư viện</h3>
            <p class="quick-card-desc">Duyệt toàn bộ truyện theo thể loại, độ nổi bật và mức giá phù hợp với bạn.</p>
        </a>

        <a href="<?php echo PUBLIC_URL; ?>/Main.php?id=1" class="quick-card">
            <h3 class="headline quick-card-title">Đọc tiếp</h3>
            <p class="quick-card-desc">Mở nhanh trang chi tiết để xem nội dung, chương mới và thông tin tác giả.</p>
        </a>

        <a href="<?php echo PUBLIC_URL; ?>/StoryMarket.php" class="quick-card">
            <h3 class="headline quick-card-title">Chợ truyện</h3>
            <p class="quick-card-desc">Theo dõi tác phẩm đang được săn đón, gói ưu đãi và gian hàng của nghệ sĩ độc lập.</p>
        </a>
    </div>
</section>

<section class="newsletter-section section-spacing">
    <div class="container newsletter-container">
        <h2 class="newsletter-title">Đừng bỏ lỡ truyện mới</h2>
        <p class="newsletter-desc">Nhận thông báo về truyện mới, ưu đãi và nội dung nổi bật mỗi tuần.</p>

        <?php if ($thongBao !== ''): ?>
            <div class="newsletter-message">
                <?php echo $thongBao; ?>
            </div>
        <?php endif; ?>

        <form class="newsletter-form" method="post">
            <input
                type="email"
                name="email"
                class="newsletter-input"
                placeholder="Nhập email của bạn"
            >
            <button type="submit" class="newsletter-button">
                Đăng ký
            </button>
        </form>
    </div>
</section>

<script src="../assets/js/public/index.js"></script>

<?php require_once __DIR__ . '/../include/user/UserFooter.php'; ?>