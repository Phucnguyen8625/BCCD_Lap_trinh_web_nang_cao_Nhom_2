<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController {
    public function index() {
        // Bảo vệ: cần đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        // Lấy thông tin user từ session
        $user = $_SESSION['user_login'];

        $message = '';
        $messageType = '';

        // Xử lý cập nhật thông tin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            if (!empty($full_name)) {
                $stmt = $db->prepare("UPDATE users SET full_name = :name, updated_at = NOW() WHERE id = :id");
                $stmt->bindParam(':name', $full_name);
                $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $_SESSION['user_login']['full_name'] = $full_name;
                    $user['full_name'] = $full_name;
                    $message = 'Cập nhật thành công!';
                    $messageType = 'success';
                }
            }

            // Đổi mật khẩu
            $old_pass = $_POST['old_password'] ?? '';
            $new_pass = $_POST['new_password'] ?? '';
            if (!empty($old_pass) && !empty($new_pass)) {
                $stmt = $db->prepare("SELECT password FROM users WHERE id = :id");
                $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row && password_verify($old_pass, $row['password'])) {
                    if (strlen($new_pass) >= 6) {
                        $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                        $stmt2 = $db->prepare("UPDATE users SET password = :pw WHERE id = :id");
                        $stmt2->bindParam(':pw', $hashed);
                        $stmt2->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
                        $stmt2->execute();
                        $message = 'Đổi mật khẩu thành công!';
                        $messageType = 'success';
                    } else {
                        $message = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
                        $messageType = 'error';
                    }
                } else {
                    $message = 'Mật khẩu cũ không đúng.';
                    $messageType = 'error';
                }
            }
        }

        // Lấy thông tin mới nhất từ DB
        $stmt = $db->prepare("SELECT id, full_name, username, email, role, created_at FROM users WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/user/profile/index.php';
    }
}
?>
