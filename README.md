# EduDoc - Study Sharing Site

## Cấu trúc thư mục

- `assets/` : Tài nguyên tĩnh (CSS, JS, images)
- `includes/` : File dùng chung (header, footer, db_connect, functions)
- `uploads/` : File người dùng upload
- `auth/` : Chức năng xác thực (login, register, logout, create_admin)
- `admin/` : Chức năng quản trị (dashboard, quản lý user, tài liệu, phân quyền, nhận xét)
- `index.php` : Trang chủ
- `search.php` : Tìm kiếm
- `upload.php` : Upload tài liệu

## Hướng dẫn
- Di chuyển các file chức năng vào đúng thư mục như trên để dễ bảo trì, mở rộng.
- Sửa lại các đường dẫn file include/require cho phù hợp với vị trí mới.
