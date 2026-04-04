# PHÂN TÍCH YÊU CẦU HỆ THỐNG
**Dự án:** Xây dựng website bán truyện tranh
**Nhóm thực hiện:** Nhóm 2
**Người phụ trách phân tích:** Nguyễn Huy Phúc
**Ngày cập nhật:** 03/04/2026

---

## 1. MỤC TIÊU HỆ THỐNG
Xây dựng một nền tảng thương mại điện tử chuyên cung cấp truyện tranh, cho phép người dùng dễ dàng tìm kiếm, đọc thử và đặt mua truyện online. Đồng thời cung cấp công cụ quản trị mạnh mẽ cho ban quản trị (Admin) để kiểm soát dữ liệu và doanh thu.

---

## 2. CHI TIẾT CHỨC NĂNG ADMIN (QUẢN TRỊ VIÊN)

### 2.1. Quản lý người dùng
* Xem danh sách tất cả tài khoản người dùng đã đăng ký.
* Khóa/Mở khóa tài khoản nếu có dấu hiệu vi phạm.
* Phân quyền (Gán quyền Admin hoặc User).

### 2.2. Quản lý danh mục truyện
* Thêm, sửa, xóa các thể loại truyện (Ví dụ: Manga, Manhwa, Hành động, Tình cảm...).
* Sắp xếp vị trí hiển thị của các danh mục trên trang chủ.

### 2.3. Quản lý truyện tranh
* Thêm truyện mới (Nhập tên, tác giả, nhà xuất bản, mô tả, ảnh bìa, giá bán).
* Cập nhật thông tin, giá cả hoặc số lượng tồn kho.
* Xóa hoặc ẩn truyện khỏi hệ thống.

### 2.4. Quản lý đơn hàng
* Xem danh sách đơn hàng được đặt từ User.
* Cập nhật trạng thái đơn hàng (Chờ xác nhận, Đang giao, Hoàn thành, Đã hủy).
* Xem chi tiết từng đơn (Người mua, địa chỉ, sản phẩm, tổng tiền).

### 2.5. Quản lý thanh toán
* Kiểm tra các giao dịch thanh toán online.
* Đối soát các khoản thanh toán qua ví điện tử/ngân hàng.

### 2.6. Thống kê / Báo cáo
* Thống kê doanh thu theo ngày, tháng, năm.
* Báo cáo top truyện bán chạy nhất.
* Thống kê lượng người dùng mới.

---

## 3. CHI TIẾT CHỨC NĂNG USER (NGƯỜI DÙNG)

### 3.1. Giao diện Trang chủ
* Hiển thị banner, truyện mới ra mắt, truyện nổi bật/bán chạy.
* Hiển thị danh sách truyện theo từng danh mục.

### 3.2. Đăng ký / Đăng nhập
* Đăng ký tài khoản mới qua Email.
* Đăng nhập vào hệ thống.
* Quên mật khẩu/Khôi phục mật khẩu.

### 3.3. Tìm kiếm truyện
* Thanh tìm kiếm theo tên truyện, tên tác giả.
* Lọc truyện nâng cao theo thể loại, khoảng giá.

### 3.4. Giỏ hàng
* Thêm truyện vào giỏ.
* Tăng/giảm số lượng hoặc xóa truyện khỏi giỏ.
* Hiển thị tổng tiền tạm tính.

### 3.5. Thanh toán online
* Nhập thông tin giao hàng (Họ tên, SĐT, Địa chỉ).
* Chọn phương thức thanh toán (COD hoặc Thanh toán Online).
* Xác nhận đặt hàng thành công.

### 3.6. Quản lý đơn hàng cá nhân
* Xem lịch sử các đơn đã đặt.
* Theo dõi trạng thái đơn hàng hiện tại.
* Hủy đơn hàng (nếu đang ở trạng thái Chờ xác nhận).

### 3.7. Cập nhật thông tin cá nhân
* Chỉnh sửa thông tin profile (Tên, SĐT, Địa chỉ mặc định).
* Thay đổi mật khẩu.