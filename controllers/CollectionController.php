<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';

class CollectionController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $comicModel = new Comic($db);
        $categoryModel = new Category($db);
        
        $type = isset($_GET['type']) ? $_GET['type'] : 'sale';
        $title = 'Danh sách truyện';
        if($type == 'all') {
            $title = 'TẤT CẢ SẢN PHẨM';
            $stmt = $comicModel->readAll();
        } else {
            switch($type) {
                case 'sale':
                    $title = 'TRUYỆN SALE HOT';
                    $flag = 'is_sale';
                    break;
                case 'bestseller':
                    $title = 'TRUYỆN BÁN CHẠY NHẤT';
                    $flag = 'is_bestseller';
                    break;
                case 'combo':
                    $title = 'TRUYỆN COMBO TIẾT KIỆM';
                    $flag = 'is_combo';
                    break;
                case 'preorder':
                    $title = 'TRUYỆN PRE-ORDER (ĐẶT TRƯỚC)';
                    $flag = 'is_preorder';
                    break;
                default:
                    $flag = 'is_sale';
            }
            $stmt = $comicModel->readByFlag($flag);
        }

        $comics = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        $categories = $categoryModel->getAllActive();

        require_once __DIR__ . '/../views/user/collection/index.php';
    }
}
?>
