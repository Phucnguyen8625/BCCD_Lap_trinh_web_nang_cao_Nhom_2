<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Category.php';

class UserOrderController {
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

        // Lấy đơn hàng theo email của user đang đăng nhập
        $userEmail = $_SESSION['user_login']['email'] ?? '';
        $orders = [];

        if (!empty($userEmail)) {
            $stmt = $db->prepare(
                "SELECT o.*, COUNT(od.id) as item_count
                 FROM orders o
                 LEFT JOIN order_details od ON od.order_id = o.id
                 WHERE o.customer_email = :email
                 GROUP BY o.id
                 ORDER BY o.created_at DESC"
            );
            $stmt->bindParam(':email', $userEmail);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        require_once __DIR__ . '/../views/user/orders/index.php';
    }

    public function detail() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $orderId = (int)($_GET['id'] ?? 0);
        if (!$orderId) {
            header('Location: index.php?controller=userorder');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();

        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        $userEmail = $_SESSION['user_login']['email'] ?? '';

        // Lấy thông tin đơn hàng (chỉ nếu là của user này)
        $stmt = $db->prepare("SELECT * FROM orders WHERE id = :id AND customer_email = :email LIMIT 1");
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':email', $userEmail);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            header('Location: index.php?controller=userorder');
            exit;
        }

        // Lấy chi tiết sản phẩm trong đơn
        $stmt2 = $db->prepare(
            "SELECT od.*, c.name as comic_name, c.image_url, c.author
             FROM order_details od
             LEFT JOIN comics c ON c.id = od.comic_id
             WHERE od.order_id = :oid"
        );
        $stmt2->bindParam(':oid', $orderId, PDO::PARAM_INT);
        $stmt2->execute();
        $orderItems = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/user/orders/detail.php';
    }
}
?>
