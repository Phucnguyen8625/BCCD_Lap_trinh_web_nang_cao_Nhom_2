<?php
require_once __DIR__ . '/../config/auth.php';

batBuocDangNhap();
yeuCauAdmin();

if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$message = '';
$messageType = 'success';
$action = trim($_GET['action'] ?? '');
$userId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$currentUserId = $_SESSION['user_login']['id'] ?? 0;

function findUserIndexById(int $id): ?int
{
    foreach ($_SESSION['users'] as $index => $user) {
        if (isset($user['id']) && (int) $user['id'] === $id) {
            return $index;
        }
    }
    return null;
}

if ($action !== '' && $userId > 0) {
    $targetIndex = findUserIndexById($userId);

    if ($targetIndex === null) {
        $message = 'Người dùng không tồn tại.';
        $messageType = 'error';
    } else {
        $targetUser = $_SESSION['users'][$targetIndex];

        if ($action === 'toggle_status') {
            if ($userId === $currentUserId) {
                $message = 'Bạn không thể thay đổi trạng thái cho chính mình.';
                $messageType = 'error';
            } elseif (($targetUser['status'] ?? 'active') === 'active') {
                $_SESSION['users'][$targetIndex]['status'] = 'locked';
                $message = 'Tài khoản đã bị khóa.';
            } else {
                $_SESSION['users'][$targetIndex]['status'] = 'active';
                $message = 'Tài khoản đã được kích hoạt lại.';
            }
        } elseif ($action === 'toggle_role') {
            if ($userId === $currentUserId) {
                $message = 'Bạn không thể thay đổi vai trò của chính mình.';
                $messageType = 'error';
            } else {
                $newRole = ($targetUser['role'] ?? 'user') === 'admin' ? 'user' : 'admin';
                $_SESSION['users'][$targetIndex]['role'] = $newRole;
                $message = 'Vai trò người dùng đã được cập nhật.';
            }
        }
    }

    if ($message !== '') {
        $messageType = $messageType === 'error' ? 'error' : 'success';
    }

    header('Location: users.php');
    exit;
}

$currentUser = $_SESSION['user_login'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="../assets/css/admin/adminStyle.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <h2>Kinetic Ink</h2>
                <p>Admin dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="users.php">Danh sách người dùng</a></li>
                <li><a href="../public/sign/up/login.php" class="logout-link">Đăng xuất</a></li>
            </ul>
        </aside>

        <div class="admin-main">
            <div class="admin-topbar">
                <h1>Quản lý người dùng</h1>
                <div class="admin-user">Xin chào, <?php echo e($currentUser['full_name'] ?? 'Quản trị viên'); ?></div>
            </div>

            <div class="admin-content">
                <?php if ($message !== ''): ?>
                    <div class="card">
                        <p class="<?php echo $messageType === 'error' ? 'text-red-600' : 'text-green-600'; ?>"><?php echo e($message); ?></p>
                    </div>
                <?php endif; ?>

                <div class="content-box">
                    <div class="page-action">
                        <div>
                            <h2>Danh sách người dùng</h2>
                            <p>Quản trị xem danh sách, khoá/mở tài khoản và chuyển quyền admin/user.</p>
                        </div>
                        <a href="../public/header/index.php" class="market-btn market-btn--secondary">Về trang người dùng</a>
                    </div>

                    <div class="table-responsive">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="background:#f8fafc;text-align:left;">
                                    <th style="padding:12px;border:1px solid #e2e8f0;">ID</th>
                                    <th style="padding:12px;border:1px solid #e2e8f0;">Họ tên</th>
                                    <th style="padding:12px;border:1px solid #e2e8f0;">Email</th>
                                    <th style="padding:12px;border:1px solid #e2e8f0;">Vai trò</th>
                                    <th style="padding:12px;border:1px solid #e2e8f0;">Trạng thái</th>
                                    <th style="padding:12px;border:1px solid #e2e8f0;">Xác thực</th>
                                    <th style="padding:12px;border:1px solid #e2e8f0;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($_SESSION['users'])): ?>
                                    <tr>
                                        <td colspan="7" style="padding:20px;text-align:center;">Chưa có người dùng nào.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($_SESSION['users'] as $user): ?>
                                        <tr>
                                            <td style="padding:12px;border:1px solid #e2e8f0;"><?php echo e($user['id'] ?? ''); ?></td>
                                            <td style="padding:12px;border:1px solid #e2e8f0;"><?php echo e($user['full_name'] ?? ''); ?></td>
                                            <td style="padding:12px;border:1px solid #e2e8f0;"><?php echo e($user['email'] ?? ''); ?></td>
                                            <td style="padding:12px;border:1px solid #e2e8f0;"><?php echo e($user['role'] ?? 'user'); ?></td>
                                            <td style="padding:12px;border:1px solid #e2e8f0;"><?php echo e(($user['status'] ?? 'active') === 'active' ? 'Hoạt động' : 'Khóa'); ?></td>
                                            <td style="padding:12px;border:1px solid #e2e8f0;"><?php echo e(!empty($user['is_verified']) ? 'Đã xác thực' : 'Chưa xác thực'); ?></td>
                                            <td style="padding:12px;border:1px solid #e2e8f0;">
                                                <?php if (($user['id'] ?? 0) !== $currentUserId): ?>
                                                    <a href="?action=toggle_status&id=<?php echo (int) $user['id']; ?>" style="margin-right:8px;"><?php echo ($user['status'] ?? 'active') === 'active' ? 'Khóa' : 'Mở khóa'; ?></a>
                                                    <a href="?action=toggle_role&id=<?php echo (int) $user['id']; ?>"><?php echo ($user['role'] ?? 'user') === 'admin' ? 'Giáng user' : 'Cấp admin'; ?></a>
                                                <?php else: ?>
                                                    <span style="color:#9ca3af;">Không có hành động</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
