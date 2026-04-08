<?php
require_once __DIR__ . '/../config/AdminConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userHomeUrl = '../public/index.php';
$registerUrl = '../public/register.php';
$libraryUrl = '../public/library.php';
$adminHomeUrl = './dashboard/index.php';

if (isAdminLoggedIn()) {
    header('Location: ' . $adminHomeUrl);
    exit;
}

if (!empty($_SESSION['user_logged_in']) || !empty($_SESSION['user'])) {
    header('Location: ' . $userHomeUrl);
    exit;
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$error = '';
$old = [
    'username' => '',
    'remember' => false,
];

$adminAccounts = [
    [
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => '123456',
        'name' => 'Quản trị viên',
    ],
];

$userAccounts = [
    [
        'username' => 'user',
        'email' => 'user@gmail.com',
        'password' => '123456',
        'name' => 'Người dùng',
    ],
    [
        'username' => 'baodeptrai',
        'email' => 'bao@gmail.com',
        'password' => '123456',
        'name' => 'Nguyễn Bảo',
    ],
];

function timTaiKhoan(array $danhSach, string $dangNhap, string $matKhau): ?array
{
    foreach ($danhSach as $taiKhoan) {
        $dungTen = strcasecmp($dangNhap, $taiKhoan['username']) === 0;
        $dungEmail = strcasecmp($dangNhap, $taiKhoan['email']) === 0;
        $dungMatKhau = $matKhau === $taiKhoan['password'];

        if (($dungTen || $dungEmail) && $dungMatKhau) {
            return $taiKhoan;
        }
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['username'] = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $old['remember'] = !empty($_POST['remember']);

    if ($old['username'] === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ tài khoản và mật khẩu.';
    } else {
        $admin = timTaiKhoan($adminAccounts, $old['username'], $password);
        $user = timTaiKhoan($userAccounts, $old['username'], $password);

        if ($admin !== null) {
            unset($_SESSION['user_logged_in'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user'], $_SESSION['user_library']);

            adminLogin([
                'username' => $admin['username'],
                'name' => $admin['name'],
            ]);

            $_SESSION['admin_email'] = $admin['email'];

            header('Location: ' . $adminHomeUrl);
            exit;
        }

        if ($user !== null) {
            unset($_SESSION['admin_logged_in'], $_SESSION['admin_username'], $_SESSION['admin_name'], $_SESSION['admin_email']);

            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user'] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'username' => $user['username'],
            ];

            if (!isset($_SESSION['user_library']) || !is_array($_SESSION['user_library'])) {
                $_SESSION['user_library'] = [];
            }

            header('Location: ' . $userHomeUrl);
            exit;
        }

        $error = 'Sai tài khoản hoặc mật khẩu.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>

    <link rel="stylesheet" href="../assets/css/admin/adminStyle.css">
    <link rel="stylesheet" href="../assets/css/admin/loginStyle.css">
</head>
<body>
    <div class="login-page">
        <div class="login-layout">
            <section class="login-left" aria-hidden="true">
                <div class="login-left__overlay"></div>

                <div class="login-left__content">
                    <div class="login-brand">Kinetic Ink</div>

                    <div class="login-hero">
                        <h1>
                            Chào mừng<br>
                            quay lại<br>
                            <span>hệ thống.</span>
                        </h1>

                        <p>
                            Quay lại bộ sưu tập của bạn. Nội dung mới đã sẵn sàng,
                            các câu chuyện đang chờ bạn khám phá,
                            và thế giới truyện vẫn đang mở rộng.
                        </p>
                    </div>

                    <div class="login-left__footer">
                        <div class="login-slider-dots">
                            <span class="active"></span>
                            <span class="medium"></span>
                            <span class="small"></span>
                        </div>

                        <div class="login-issue-card">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M4 5.5C4 4.67157 4.67157 4 5.5 4H11.25C12.2165 4 13 4.7835 13 5.75V19.5L9.8 17.9C9.29289 17.6464 8.70711 17.6464 8.2 17.9L5 19.5V5.5Z" stroke="currentColor" stroke-width="1.7"/>
                                <path d="M13 5.75C13 4.7835 13.7835 4 14.75 4H18.5C19.3284 4 20 4.67157 20 5.5V19.5L16.8 17.9C16.2929 17.6464 15.7071 17.6464 15.2 17.9L13 19V5.75Z" stroke="currentColor" stroke-width="1.7"/>
                            </svg>
                            <span>Số #402</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="login-right">
                <div class="login-form-shell">
                    <div class="login-form-box">
                        <h2 class="login-title">Đăng nhập</h2>
                        <p class="login-subtitle">Tiếp tục hành trình của bạn trong thế giới truyện.</p>

                        <?php if ($error !== ''): ?>
                            <div class="login-error"><?php echo e($error); ?></div>
                        <?php endif; ?>

                        <form method="post" class="login-form" id="adminLoginForm">
                            <div class="login-field">
                                <label for="username">Tên đăng nhập hoặc email</label>
                                <div class="login-input-wrap">
                                    <input
                                        id="username"
                                        type="text"
                                        name="username"
                                        value="<?php echo e($old['username']); ?>"
                                        placeholder="Nhập tên đăng nhập hoặc email"
                                        autocomplete="username"
                                    >
                                    <span class="login-input-icon">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M4 7.5C4 6.67157 4.67157 6 5.5 6H18.5C19.3284 6 20 6.67157 20 7.5V16.5C20 17.3284 19.3284 18 18.5 18H5.5C4.67157 18 4 17.3284 4 16.5V7.5Z" stroke="currentColor" stroke-width="1.8"/>
                                            <path d="M5 7L12 12.5L19 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="login-field">
                                <div class="login-field-head">
                                    <label for="password">Mật khẩu</label>
                                    <a href="#">Quên mật khẩu?</a>
                                </div>

                                <div class="login-input-wrap">
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="••••••••••"
                                        autocomplete="current-password"
                                    >
                                    <button type="button" class="login-toggle-password" id="togglePassword" aria-label="Hiện mật khẩu">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M8 10V7.75C8 5.67893 9.67893 4 11.75 4C13.8211 4 15.5 5.67893 15.5 7.75V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                            <path d="M7 10H16.5C17.3284 10 18 10.6716 18 11.5V18.5C18 19.3284 17.3284 20 16.5 20H7C6.17157 20 5.5 19.3284 5.5 18.5V11.5C5.5 10.6716 6.17157 10 7 10Z" stroke="currentColor" stroke-width="1.8"/>
                                            <circle cx="11.75" cy="14.5" r="1.2" fill="currentColor"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <label class="login-remember" for="remember">
                                <input id="remember" type="checkbox" name="remember" <?php echo $old['remember'] ? 'checked' : ''; ?>>
                                <span>Giữ trạng thái đăng nhập</span>
                            </label>

                            <button type="submit" class="login-submit">
                                <span>Vào hệ thống</span>
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M12.5 6L18.5 12L12.5 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>

                        <div class="login-divider">Hoặc đăng nhập bằng</div>

                        <div class="login-social-grid">
                            <a href="#" class="login-social-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21.8 12.227c0-.709-.064-1.39-.182-2.045H12v3.87h5.498c-.237 1.279-.955 2.363-2.036 3.087v2.567h3.296c1.93-1.777 3.042-4.396 3.042-7.479Z"/>
                                    <path d="M12 22c2.76 0 5.074-.915 6.765-2.479l-3.296-2.567c-.915.613-2.084.976-3.469.976-2.669 0-4.931-1.803-5.74-4.227H2.854v2.648A10 10 0 0 0 12 22Z"/>
                                    <path d="M6.26 13.703A5.993 5.993 0 0 1 5.94 12c0-.591.102-1.164.32-1.703V7.649H2.854A10 10 0 0 0 2 12c0 1.614.386 3.14 1.07 4.351l3.19-2.648Z"/>
                                    <path d="M12 6.07c1.502 0 2.85.517 3.912 1.531l2.934-2.934C17.07 3.005 14.756 2 12 2A10 10 0 0 0 3.07 7.649l3.19 2.648C7.069 7.873 9.33 6.07 12 6.07Z"/>
                                </svg>
                                <span>Google</span>
                            </a>

                            <a href="#" class="login-social-btn">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="7" stroke="currentColor" stroke-width="1.8"/>
                                    <circle cx="10" cy="10" r="1.3" fill="currentColor"/>
                                    <circle cx="15" cy="9" r="1.1" fill="currentColor"/>
                                    <circle cx="14.5" cy="14" r="1.1" fill="currentColor"/>
                                    <path d="M12 12C11 14.3 9.4 15.6 7 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                                <span>Facebook</span>
                            </a>
                        </div>

                        <div class="login-signup">
                            <span>Bạn chưa có tài khoản?</span>
                            <a href="<?php echo e($registerUrl); ?>">Đăng ký</a>
                        </div>
                    </div>

                    <div class="login-copyright">© 2024 Kinetic Ink. Đã đăng ký mọi quyền.</div>
                </div>
            </section>
        </div>
    </div>

    <script src="../assets/js/admin/login.js"></script>
</body>
</html>