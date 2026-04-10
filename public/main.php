<?php
require_once __DIR__ . '/../config/auth.php';
batBuocDangNhap();

$pageTitle = 'Chi tiết truyện';
require_once __DIR__ . '/../config/webConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/theme.php';
$themeHienTai = layThemeHienTai();

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('kiemTraDangNhapNguoiDung')) {
    function kiemTraDangNhapNguoiDung(): bool
    {
        return !empty($_SESSION['user_logged_in']) || !empty($_SESSION['user']) || !empty($_SESSION['user_login']);
    }
}

if (!kiemTraDangNhapNguoiDung()) {
    header('Location: ./sign/up/login.php');
    exit;
}

$danhSachTruyen = [
    1 => [
        'id' => 1,
        'ten' => 'Kimetsu no Yaiba',
        'gia' => '79.000đ',
        'theLoai' => 'Phiêu lưu',
        'tacGia' => 'Koyoharu Gotouge',
        'soChuong' => 12,
        'danhGia' => '4.8/5',
        'moTa' => 'Tanjiro, một cậu bé phát hiện rằng gia đình mình đã bị tàn sát, chỉ có em gái Nezuko sống sót nhưng bị biến thành quỷ. Để cứu em gái, cậu bế tìm kiếm cách biến Nezuko trở lại con người.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/1286/99889.jpg',
        'chuongMoi' => ['Chương 10: Quyết tâm của nhóm thợ săn quỷ', 'Chương 11: Tứ quỷ cuối cùng', 'Chương 12: Tanjiro trở lại'],
    ],
    2 => [
        'id' => 2,
        'ten' => 'Boku no Hero Academia',
        'gia' => '89.000đ',
        'theLoai' => 'Hành động',
        'tacGia' => 'Kohei Horikoshi',
        'soChuong' => 8,
        'danhGia' => '4.9/5',
        'moTa' => 'Izuku Midoriya sinh ra trong một thế giới nơi 80% dân số có siêu năng lực. Không có chiêu này, cậu vẫn quyết tâm trở thành một anh hùng và vào một trường đào tạo anh hùng hàng đầu.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/10/78745.jpg',
        'chuongMoi' => ['Chương 6: Siêu năng lực giục dục', 'Chương 7: Bắt đầu kỷ nguyên mới', 'Chương 8: Người hùng cải tạo'],
    ],
    3 => [
        'id' => 3,
        'ten' => 'Jujutsu Kaisen',
        'gia' => '99.000đ',
        'theLoai' => 'Kỳ ảo',
        'tacGia' => 'Gege Akutami',
        'soChuong' => 20,
        'danhGia' => '4.7/5',
        'moTa' => 'Yuji Itadori là một thiếu niên bình thường cho đến khi anh nuốt một ngón tay của một quỷ luyện tập, trở thành vũ khí của một phù thủy. Anh trở thành ứng cử viên để trở thành phù thủy luyện tập hàng đầu.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/1171/109222.jpg',
        'chuongMoi' => ['Chương 18: Sức mạnh vô giới hạn', 'Chương 19: Cuộc chiến ngàn năm', 'Chương 20: Phù thủy chân chính'],
    ],
    4 => [
        'id' => 4,
        'ten' => 'Tokyo Ghoul',
        'gia' => '69.000đ',
        'theLoai' => 'Bí ẩn',
        'tacGia' => 'Sui Ishida',
        'soChuong' => 5,
        'danhGia' => '4.6/5',
        'moTa' => 'Ken Kaneki, một thanh niên bình thường, bị biến thành một nửa quỷ sau một vụ tai nạn. Anh phải học cách sống giữa hai thế giới - người và quỷ, trong khi che giấu bí mật của mình.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/5/64449.jpg',
        'chuongMoi' => ['Chương 3: Những người ăn carcass', 'Chương 4: Bên trong cơ thể bọc lông', 'Chương 5: Hành động của Antique'],
    ],
    5 => [
        'id' => 5,
        'ten' => 'Naruto',
        'gia' => '89.000đ',
        'theLoai' => 'Hành động',
        'tacGia' => 'Masashi Kishimoto',
        'soChuong' => 45,
        'danhGia' => '4.9/5',
        'moTa' => 'Naruto là câu chuyện về cậu bé Naruto Uzumaki, ước mơ trở thành Hokage và hành trình vượt qua định kiến để bảo vệ làng Lá.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/13/17405.jpg',
        'chuongMoi' => ['Chương 43: Mạng ninja rực lửa', 'Chương 44: Quyết tâm làng Lá', 'Chương 45: Hokage tiếp theo'],
    ],
    6 => [
        'id' => 6,
        'ten' => 'Kaichou wa Maid-sama',
        'gia' => '75.000đ',
        'theLoai' => 'Tình cảm',
        'tacGia' => 'Hiro Fujiwara',
        'soChuong' => 31,
        'danhGia' => '4.5/5',
        'moTa' => 'Câu chuyện về cô chủ tịch hội học sinh công tử, vừa nghiêm khắc vừa ngại ngùng khi làm việc bán thời gian ở quán cà phê hầu gái.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/6/25254.jpg',
        'chuongMoi' => ['Chương 29: Bí mật được giữ kín', 'Chương 30: Cảm xúc dâng trào', 'Chương 31: Lời thề của hai người'],
    ],
    7 => [
        'id' => 7,
        'ten' => 'Assassination Classroom',
        'gia' => '55.000đ',
        'theLoai' => 'Học đường',
        'tacGia' => 'Yusei Matsui',
        'soChuong' => 27,
        'danhGia' => '4.4/5',
        'moTa' => 'Một lớp học đặc biệt được giao nhiệm vụ ám sát thầy giáo ngoài hành tinh trước khi ngôi sao mặt trời bị phá hủy.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/5/75639.jpg',
        'chuongMoi' => ['Chương 25: Kế hoạch cuối cùng', 'Chương 26: Sự hy sinh của lớp E', 'Chương 27: Tương lai mới'],
    ],
    8 => [
        'id' => 8,
        'ten' => 'Steins;Gate',
        'gia' => '79.000đ',
        'theLoai' => 'Phiêu lưu',
        'tacGia' => '5pb. & Nitroplus',
        'soChuong' => 16,
        'danhGia' => '4.8/5',
        'moTa' => 'Một nhóm bạn phát hiện khả năng gửi tin nhắn ngược thời gian và phải trả giá bằng những hệ quả thay đổi lịch sử.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/5/73199.jpg',
        'chuongMoi' => ['Chương 14: Mảnh thời gian rạn vỡ', 'Chương 15: Tiếng thì thầm trong đêm', 'Chương 16: Quyết định cuối cùng'],
    ],
    9 => [
        'id' => 9,
        'ten' => 'One Piece',
        'gia' => '99.000đ',
        'theLoai' => 'Fantasy',
        'tacGia' => 'Eiichiro Oda',
        'soChuong' => 88,
        'danhGia' => '4.9/5',
        'moTa' => 'Hành trình của Luffy và nhóm Mũ Rơm đi tìm báu vật One Piece để trở thành Vua Hải Tặc.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/6/73245.jpg',
        'chuongMoi' => ['Chương 86: Biển đỏ bão tố', 'Chương 87: Đối thủ mới', 'Chương 88: Vinh quang tự do'],
    ],
    10 => [
        'id' => 10,
        'ten' => 'Fullmetal Alchemist',
        'gia' => '89.000đ',
        'theLoai' => 'Phiêu lưu',
        'tacGia' => 'Hiromu Arakawa',
        'soChuong' => 73,
        'danhGia' => '4.8/5',
        'moTa' => 'Hai anh em Edward và Alphonse Elric tìm đá hiếm Philosopher để phục hồi cơ thể sau khi phép thuật cấm kỵ biến mất.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/10/75815.jpg',
        'chuongMoi' => ['Chương 71: Lời thề cuối cùng', 'Chương 72: Người anh hùng chân chính', 'Chương 73: Hồi sinh mới'],
    ],
    11 => [
        'id' => 11,
        'ten' => 'Death Note',
        'gia' => '69.000đ',
        'theLoai' => 'Trinh thám',
        'tacGia' => 'Tsugumi Ohba',
        'soChuong' => 54,
        'danhGia' => '4.9/5',
        'moTa' => 'Cuốn sổ tử thần cho phép người sở hữu giết người bằng cách viết tên họ, mở ra trò chơi trí tuệ giữa Light và thám tử L.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/9/9453.jpg',
        'chuongMoi' => ['Chương 52: Âm mưu L', 'Chương 53: Kết thúc số phận', 'Chương 54: Ký ức im lặng'],
    ],
    12 => [
        'id' => 12,
        'ten' => 'Bleach',
        'gia' => '79.000đ',
        'theLoai' => 'Hành động',
        'tacGia' => 'Tite Kubo',
        'soChuong' => 60,
        'danhGia' => '4.7/5',
        'moTa' => 'Ichigo Kurosaki vô tình nhận sức mạnh Thần Chết và bước vào thế giới linh hồn, chiến đấu bảo vệ người sống khỏi quỷ dữ.',
        'anh' => 'https://cdn.myanimelist.net/images/anime/3/40451.jpg',
        'chuongMoi' => ['Chương 58: Bão kiếm phủ bóng', 'Chương 59: Quyết chiến Soul Society', 'Chương 60: Sức mạnh của trái tim'],
    ],
];

$id = (int) ($_GET['id'] ?? 1);
$truyen = $danhSachTruyen[$id] ?? reset($danhSachTruyen);

require_once __DIR__ . '/../include/user/userHeader.php';
?>

<link rel="stylesheet" href="../assets/css/public/mainStyle.css">

<div class="theme-<?= htmlspecialchars($themeHienTai) ?>">
<section class="story-detail-section">
    <div class="story-detail-container">
        <div class="story-detail-grid">
            <div class="story-cover-card">
                <img src="<?php echo e($truyen['anh']); ?>" alt="<?php echo e($truyen['ten']); ?>" class="story-cover-image">
            </div>

            <div class="story-detail-content">
                <div class="story-badges">
                    <span class="story-badge story-badge-orange"><?php echo e($truyen['theLoai']); ?></span>
                    <span class="story-badge story-badge-blue">Đánh giá <?php echo e($truyen['danhGia']); ?></span>
                </div>

                <h1 class="headline story-detail-title"><?php echo e($truyen['ten']); ?></h1>
                <p class="story-detail-desc"><?php echo e($truyen['moTa']); ?></p>

                <div class="story-stats-grid">
                    <div class="story-stat-card">
                        <p class="story-stat-label">Tác giả</p>
                        <p class="story-stat-value"><?php echo e($truyen['tacGia']); ?></p>
                    </div>
                    <div class="story-stat-card">
                        <p class="story-stat-label">Số chương</p>
                        <p class="story-stat-value"><?php echo e((string) $truyen['soChuong']); ?></p>
                    </div>
                    <div class="story-stat-card">
                        <p class="story-stat-label">Giá truyện</p>
                        <p class="story-stat-value"><?php echo e($truyen['gia']); ?></p>
                    </div>
                </div>

                <div class="story-detail-actions">
                    <a href="./header/list.php?add=<?php echo (int) $truyen['id']; ?>" class="story-action-btn story-action-btn-gradient">
                        Thêm vào tủ truyện
                    </a>
                    <a href="./header/library.php" class="story-action-btn story-action-btn-soft">
                        Quay về thư viện
                    </a>
                    <a href="./header/storyMarket.php" class="story-action-btn story-action-btn-blue">
                        Xem giá tại chợ truyện
                    </a>
                </div>

                <div class="chapter-box">
                    <div class="chapter-box-header">
                        <h2 class="headline chapter-box-title">Chương mới cập nhật</h2>
                        <a href="./header/list.php?add=<?php echo (int) $truyen['id']; ?>" class="chapter-save-link">Lưu để đọc sau</a>
                    </div>

                    <div class="chapter-list">
                        <?php foreach ($truyen['chuongMoi'] as $index => $chuong): ?>
                            <div class="chapter-item">
                                <div>
                                    <p class="chapter-part">Phần <?php echo (int) ($index + 1); ?></p>
                                    <p class="chapter-name"><?php echo e($chuong); ?></p>
                                </div>
                                <a href="./header/list.php?add=<?php echo (int) $truyen['id']; ?>" class="chapter-read-btn">
                                    Đọc ngay
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../assets/js/public/main.js"></script>
</div>

<?php require_once __DIR__ . '/../include/user/userFooter.php'; ?>
