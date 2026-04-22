<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();
        $currentCategory = $categoryId > 0 ? $categoryModel->getById($categoryId) : null;

        $comics = [];
        if ($categoryId > 0) {
            $comicModel = new Comic($db);
            $stmt = $comicModel->readByCategory($categoryId);
            $comics = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        require_once __DIR__ . '/../views/user/category/index.php';
    }
}
?>
