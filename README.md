# Báo cáo chuyên đề Lập trình Web Nâng Cao - MangaStore

## Mục lục Software Requirement Specification (SRS)

- [Quản lý người dùng](docs/srs/quan_ly_nguoi_dung.md)
- [Quản lý danh mục truyện](docs/srs/quan_ly_danh_muc_truyen.md)
- [Quản lý truyện tranh](docs/srs/quan_ly_truyen_tranh.md)
- [Quản lý đơn hàng](docs/srs/quan_ly_don_hang.md)
- [Quản lý thanh toán](docs/srs/quan_ly_thanh_toan.md)
- [Thống kê / Báo cáo](docs/srs/thong_ke_bao_cao.md)
- [Trang chủ](docs/srs/trang_chu.md)
- [Đăng ký / Đăng nhập](docs/srs/dang_ky_dang_nhap.md)
- [Tìm kiếm truyện](docs/srs/tim_kiem_truyen.md)
- [Giỏ hàng](docs/srs/gio_hang.md)
- [Thanh toán online](docs/srs/thanh_toan_online.md)
- [Quản lý đơn hàng của người dùng](docs/srs/quan_ly_don_hang_cua_nguoi_dung.md)
- [Cập nhật thông tin cá nhân](docs/srs/cap_nhat_thong_tin_ca_nhan.md)

## 1. Thông tin đề tài BCCĐ
Tên hệ thống: MangaStore - Website bán và đọc truyện tranh online  
Nhóm thực hiện: Nguyễn Huy Phúc, Nguyễn Duy Khánh, Nguyễn Dương Thế Bảo

## 2. Phần sinh viên cấu hình
- Cấu hình database trong `config/`
- Import file `database.sql`
- Cấu hình đường dẫn host trong `.htaccess`
- Cấu hình chức năng thanh toán trong `phuc_modules/checkout`

## 3. Quản lý phiên bản
Dự án được quản lý bằng Git/GitHub:
- Repository: https://github.com/Phucnguyen8625/BCCD_Lap_trinh_web_nang_cao_Nhom_2
- Có lịch sử commit, phân chia thư mục chức năng rõ ràng.

## 4. Tùy biến skin
Giao diện được tùy biến trong thư mục:
- `assets/css`
- `views`
- `public`

## 5. Lập trình tùy biến chức năng / plugin
Dự án có các module tùy biến:
- Module quản trị Admin
- Module thanh toán trong `phuc_modules/checkout`
- Module quản lý truyện, danh mục, đơn hàng, người dùng

## 6. Cơ sở dữ liệu
Dự án sử dụng MySQL, file CSDL nằm tại:
- `database.sql`
- `seed.sql`

## 7. Deploy
Link website đã deploy: https://pkbcomic.io.vn
