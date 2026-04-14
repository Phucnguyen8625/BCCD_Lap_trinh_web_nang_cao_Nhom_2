<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController {
    private $db;
    private $orderModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->orderModel = new Order($this->db);

        // Mock login if not exists for testing
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Nguyễn Duy Khánh';
        }
    }

    // View Purchase History
    public function index() {
        $user_id = $_SESSION['user_id'];
        $stmt = $this->orderModel->readByUserId($user_id);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/user/orders/index.php';
    }

    // View Order Detail
    public function detail() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('Error: Missing Order ID.');
        $user_id = $_SESSION['user_id'];

        if ($this->orderModel->readOne($id, $user_id)) {
            $stmt = $this->orderModel->getOrderItems($id);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../views/user/orders/detail.php';
        } else {
            header("Location: index.php?controller=order&action=index&error=Order not found.");
        }
    }
}
?>
