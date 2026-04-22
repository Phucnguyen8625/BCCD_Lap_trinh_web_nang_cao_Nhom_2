<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';

class SearchController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $keyword = trim($_GET['q'] ?? '');
        $results = [];

        $comicModel = new Comic($db);
        if (!empty($keyword)) {
            $stmt = $comicModel->search($keyword);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        require_once __DIR__ . '/../views/user/search/index.php';
    }
}
?>
