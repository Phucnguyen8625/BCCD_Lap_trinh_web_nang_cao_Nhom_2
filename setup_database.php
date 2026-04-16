<?php
/**
 * AUTO-SETUP DATABASE SCRIPT
 * Run this script to automatically fix missing columns or tables.
 */
require_once __DIR__ . '/config/database.php';

echo "<h2>Đang kiểm tra và đồng bộ cơ sở dữ liệu...</h2>";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // 1. Kiểm tra bảng users
    echo "<li>Kiểm tra bảng users... ";
    $checkUsername = $db->query("SHOW COLUMNS FROM users LIKE 'username'");
    if ($checkUsername->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN username VARCHAR(100) NOT NULL UNIQUE AFTER full_name");
        echo "<b>Đã thêm cột 'username'</b>";
    } else {
        echo "OK";
    }
    echo "</li>";

    // 2. Kiểm tra bảng comics
    echo "<li>Kiểm tra bảng comics... ";
    $columnsToAdd = [
        'is_sale' => "TINYINT(1) DEFAULT 0 AFTER description",
        'is_combo' => "TINYINT(1) DEFAULT 0 AFTER is_sale",
        'is_bestseller' => "TINYINT(1) DEFAULT 0 AFTER is_combo",
        'is_preorder' => "TINYINT(1) DEFAULT 0 AFTER is_bestseller"
    ];

    foreach ($columnsToAdd as $col => $definition) {
        $checkCol = $db->query("SHOW COLUMNS FROM comics LIKE '$col'");
        if ($checkCol->rowCount() == 0) {
            $db->exec("ALTER TABLE comics ADD COLUMN $col $definition");
            echo "<br>-- Đã thêm cột '$col'";
        }
    }
    echo " OK</li>";

    // 3. Kiểm tra bảng payments (đảm bảo cấu trúc hỗ trợ VNPay)
    echo "<li>Kiểm tra bảng payments... ";
    $checkTxnId = $db->query("SHOW COLUMNS FROM payments LIKE 'transaction_id'");
    if ($checkTxnId->rowCount() == 0) {
        $db->exec("ALTER TABLE payments ADD COLUMN transaction_id VARCHAR(100) NULL AFTER payment_status");
        echo "<b>Đã thêm cột 'transaction_id'</b>";
    } else {
        echo "OK";
    }
    echo " OK</li>";

    // 4. Tạo tài khoản Admin mặc định nếu chưa có
    echo "<li>Kiểm tra tài khoản Admin... ";
    $checkAdmin = $db->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    if ($checkAdmin->rowCount() == 0) {
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO users (full_name, username, email, password, role, status) 
                   VALUES ('Administrator', 'admin', 'admin@mangastore.vn', '$hashedPassword', 'admin', 'active')");
        echo "<b>Đã tạo tài khoản admin mặc định (admin / admin123)</b>";
    } else {
        echo "OK";
    }
    echo "</li>";

    echo "<h3 style='color: green;'>Đồng bộ hoàn tất! Bạn có thể quay lại sử dụng website.</h3>";
    echo "<a href='index.php'>Về trang chủ</a> | <a href='admin.php'>Vào trang Admin</a>";

} catch (PDOException $e) {
    echo "<h3 style='color: red;'>Lỗi: " . $e->getMessage() . "</h3>";
    echo "Vui lòng đảm bảo bạn đã tạo database 'ban_truyen_tranh' trong phpMyAdmin trước.";
}
?>
