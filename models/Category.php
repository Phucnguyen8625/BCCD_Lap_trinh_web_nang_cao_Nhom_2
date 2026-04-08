<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;
    public $description;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy toàn bộ danh mục
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy chi tiết 1 danh mục theo ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->status = $row['status'];
            return true;
        }
        return false;
    }

    // Thêm danh mục mới
    public function create() {
        // Kiểm tra trùng tên
        if($this->isNameExists()) {
            return "Tên danh mục đã tồn tại.";
        }

        $query = "INSERT INTO " . $this->table_name . " SET name=:name, description=:desc, status=:status";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":desc", $this->description);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật danh mục
    public function update() {
        // Nếu tên bị sửa, phải kiểm tra tên mới có bị trùng hay không
        if($this->isNameExists($this->id)) {
            return "Tên danh mục mới đã tồn tại trên một danh mục khác.";
        }

        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:desc, status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":desc", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa danh mục
    public function delete() {
        // Kiểm tra đang chứa truyện
        if($this->hasComics()) {
            return "Không thể xóa danh mục đang có truyện. Vui lòng chuyển lịch sử truyện hoặc xóa truyện trước.";
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Kiểm tra tên trùng lặp
    private function isNameExists($exclude_id = null) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE name = ?";
        if($exclude_id != null) {
            $query .= " AND id != ?";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->name);
        if($exclude_id != null) {
            $stmt->bindParam(2, $exclude_id);
        }
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // Ràng buộc tính toàn vẹn dư liệu (Kiểm tra xem danh mục có truyện không)
    private function hasComics() {
        $query = "SELECT id FROM comics WHERE category_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
?>
