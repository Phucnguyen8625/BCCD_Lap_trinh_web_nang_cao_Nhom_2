<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Category.php';

class AdminCategoryController {
    private $db;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }

    // Hiển thị danh sách
    public function index() {
        $stmt = $this->category->readAll();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../views/admin/categories/index.php';
    }

    // Hiển thị form tạo mới
    public function create() {
        require_once __DIR__ . '/../views/admin/categories/create.php';
    }

    // Xử lý tạo mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->category->name = trim($_POST['name']);
            $this->category->description = trim($_POST['description']);
            $this->category->status = isset($_POST['status']) ? 1 : 0;

            if (empty($this->category->name)) {
                $error = "Tên danh mục không được để trống!";
                require_once __DIR__ . '/../views/admin/categories/create.php';
                return;
            }

            $result = $this->category->create();
            if ($result === true) {
                header("Location: admin.php?controller=category&action=index&success=Tạo thành công");
                exit();
            } else {
                $error = $result; 
                require_once __DIR__ . '/../views/admin/categories/create.php';
            }
        }
    }

    // Hiển thị form sửa
    public function edit() {
        if (isset($_GET['id'])) {
            $this->category->id = $_GET['id'];
            if ($this->category->readOne()) {
                require_once __DIR__ . '/../views/admin/categories/edit.php';
            } else {
                header("Location: admin.php?controller=category&action=index&error=Danh mục không tồn tại");
                exit();
            }
        }
    }

    // Xử lý update
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $this->category->id = $_POST['id'];
            $this->category->name = trim($_POST['name']);
            $this->category->description = trim($_POST['description']);
            $this->category->status = isset($_POST['status']) ? 1 : 0;

            if (empty($this->category->name)) {
                $error = "Tên danh mục không được để trống!";
                require_once __DIR__ . '/../views/admin/categories/edit.php';
                return;
            }

            $result = $this->category->update();
            if ($result === true) {
                header("Location: admin.php?controller=category&action=index&success=Cập nhật thành công");
                exit();
            } else {
                $error = $result;
                require_once __DIR__ . '/../views/admin/categories/edit.php';
            }
        }
    }

    // Xử lý xóa
    public function delete() {
        if (isset($_GET['id'])) {
            $this->category->id = $_GET['id'];
            $result = $this->category->delete();
            
            if ($result === true) {
                header("Location: admin.php?controller=category&action=index&success=Xóa danh mục thành công");
            } else {
                header("Location: admin.php?controller=category&action=index&error=" . urlencode($result));
            }
            exit();
        }
    }
}
?>
