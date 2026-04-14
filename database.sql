-- Tạo Database nếu chưa có (Hãy thay đổi tên database phù hợp nếu cần)
CREATE DATABASE IF NOT EXISTS ban_truyen_tranh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ban_truyen_tranh;

-- Bảng lưu trữ Danh mục truyện (Categories)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    status TINYINT(1) DEFAULT 1 COMMENT '1: Hoạt động, 0: Ẩn',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng lưu trữ Truyện (Comics)
CREATE TABLE IF NOT EXISTS comics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    author VARCHAR(150),
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);

-- Bảng lưu trữ Người dùng (Users)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng lưu trữ Đơn hàng (Orders)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    receiver_name VARCHAR(120) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    note TEXT DEFAULT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'shipping', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    payment_method ENUM('COD', 'VNPAY') NOT NULL DEFAULT 'COD',
    payment_status ENUM('unpaid', 'pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng lưu trữ Chi tiết đơn hàng (Order Items)
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    comic_id INT DEFAULT NULL,
    comic_name VARCHAR(150) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_comic FOREIGN KEY (comic_id) REFERENCES comics(id) ON DELETE SET NULL
);

-- Dữ liệu mẫu ban đầu cho Categories
INSERT IGNORE INTO categories (id, name, description, status) VALUES 
(1, 'Hành Động', 'Truyện phiêu lưu, võ thuật, cảnh hành động mãn nhãn', 1),
(2, 'Tình Cảm', 'Truyện lãng mạn, học đường', 1),
(3, 'Kinh Dị', 'Truyện rùng rợn, giật gân, ám ảnh', 1);

-- Dữ liệu mẫu cho Users
INSERT IGNORE INTO users (id, full_name, email, password, role) VALUES
(1, 'Nguyễn Duy Khánh', 'khanh@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
(2, 'Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Dữ liệu mẫu cho Orders
INSERT IGNORE INTO orders (id, user_id, receiver_name, phone, address, total_amount, status, payment_method) VALUES
(1, 1, 'Nguyễn Duy Khánh', '0912345678', '123 Đường ABC, Hà Nội', 75000, 'completed', 'COD'),
(2, 1, 'Nguyễn Duy Khánh', '0912345678', '123 Đường ABC, Hà Nội', 45000, 'shipping', 'COD'),
(3, 1, 'Nguyễn Duy Khánh', '0912345678', '123 Đường ABC, Hà Nội', 120000, 'pending', 'VNPAY');

-- Dữ liệu mẫu cho Order Items
INSERT IGNORE INTO order_items (order_id, comic_name, price, quantity, subtotal) VALUES
(1, 'Dragon Ball Super Tập 10', 25000, 3, 75000),
(2, 'One Piece Tập 100', 45000, 1, 45000),
(3, 'Jujutsu Kaisen Tập 1', 40000, 3, 120000);
