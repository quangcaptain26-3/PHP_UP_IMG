# 📸 Gallery Project - Thư viện ảnh PHP

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8-blue?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-purple?logo=bootstrap)](https://getbootstrap.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-yellow?logo=javascript&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![Font Awesome](https://img.shields.io/badge/Font%20Awesome-6.5.2-blue?logo=fontawesome)](https://fontawesome.com/)
[![Masonry.js](https://img.shields.io/badge/Masonry.js-layout-orange)](https://masonry.desandro.com/)
[![imagesLoaded.js](https://img.shields.io/badge/imagesLoaded.js-loading-lightgrey)](https://imagesloaded.desandro.com/)
[![AJAX](https://img.shields.io/badge/AJAX-dynamic-red)](https://developer.mozilla.org/en-US/docs/Web/Guide/AJAX)
[![JSON](https://img.shields.io/badge/JSON-data-green)](https://www.json.org/)
[![Secure Uploads](https://img.shields.io/badge/File%20Upload-Secure-brightgreen)](https://www.php.net/manual/en/features.file-upload.php)
[![Session Management](https://img.shields.io/badge/Session-Management-orange)](https://www.php.net/manual/en/book.session.php)

---


Một ứng dụng web thư viện ảnh hiện đại được xây dựng bằng PHP thuần, cho phép người dùng tải lên, quản lý và xem ảnh với giao diện đẹp mắt và tính năng drag & drop.

## 🚀 Công nghệ sử dụng

### Backend
- **PHP** - Ngôn ngữ chính cho server-side logic
- **MySQL** - Cơ sở dữ liệu lưu trữ thông tin ảnh
- **MySQLi** - Extension PHP để kết nối và thao tác với MySQL

### Frontend
- **HTML5** - Cấu trúc trang web
- **CSS3** - Styling và animations
- **JavaScript (ES6+)** - Tính năng tương tác
- **Bootstrap 5.3.3** - Framework UI responsive
- **Font Awesome 6.5.2** - Icon library

### JavaScript Libraries
- **Masonry.js** - Responsive grid layout
- **imagesLoaded.js** - Image loading detection
- **Vanilla JavaScript** - Drag & drop functionality

### Công nghệ khác
- **AJAX** - Asynchronous operations
- **JSON** - Data exchange format
- **Session Management** - User session handling
- **File Upload** - Multipart form data handling

## 🔒 Tính năng bảo mật

### SQL Injection Protection
- **Prepared Statements** - Sử dụng MySQLi prepared statements cho mọi truy vấn
- **Parameter Binding** - Bind parameters để tránh SQL injection
- **Input Validation** - Kiểm tra và xác thực dữ liệu đầu vào

### File Upload Security
- **File Type Validation** - Chỉ cho phép upload file ảnh (JPG, PNG, GIF)
- **File Size Limits** - Giới hạn kích thước file tối đa 5MB
- **Unique Filename Generation** - Tạo tên file duy nhất với `uniqid()`
- **Safe File Handling** - Kiểm tra file existence trước khi xử lý

### Data Security
- **HTML Escaping** - Sử dụng `htmlspecialchars()` để tránh XSS
- **Input Sanitization** - Làm sạch dữ liệu với `trim()`
- **Error Handling** - Xử lý lỗi an toàn với try-catch blocks
- **Transaction Management** - Sử dụng database transactions

### Session Security
- **Session Management** - Quản lý session an toàn
- **Flash Messages** - Thông báo tạm thời qua session
- **Secure Headers** - Thiết lập headers bảo mật

## 🛠️ Cài đặt và chạy dự án

### Yêu cầu hệ thống
- PHP 7.4 trở lên
- MySQL 5.7 trở lên
- Web server (Apache/Nginx)
- Extension PHP: mysqli, gd

### Bước 1: Clone dự án
```bash
git clone <repository-url>
cd gallery-project
```

### Bước 2: Tạo cơ sở dữ liệu
Chạy các lệnh SQL sau trong MySQL:

```sql
-- Tạo database
CREATE DATABASE up_img;

-- Sử dụng database
USE up_img;

-- Tạo bảng images
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
);

```

### Bước 3: Cấu hình kết nối database
Mở file `connect.php` và cập nhật thông tin kết nối:

```php
$dbHost = "localhost";     // Địa chỉ MySQL server
$dbUser = "root";          // Username MySQL
$dbPass = "";              // Password MySQL
$dbName = "up_img";        // Tên database
```

### Bước 4: Tạo thư mục uploads
```bash
mkdir uploads
chmod 755 uploads
```

### Bước 5: Chạy dự án
```bash
# Sử dụng PHP built-in server
php -S localhost:8000

# Hoặc đặt trong thư mục web server
# Ví dụ: /var/www/html/ hoặc /htdocs/
```

Truy cập `http://localhost:8000` để sử dụng ứng dụng.

## 📁 Cấu trúc dự án

```
gallery-project/
├── index.php          # Trang chủ - hiển thị thư viện ảnh
├── create.php         # Trang tải ảnh lên
├── edit.php           # Trang chỉnh sửa ảnh
├── delete.php         # API xóa ảnh (AJAX)
├── connect.php        # Kết nối cơ sở dữ liệu
├── style.css          # CSS cho create/edit pages
├── cssindex.css       # CSS cho trang chủ
├── uploads/           # Thư mục chứa ảnh
└── README.md          # Tài liệu dự án
```

## 💡 Tính năng chính

### 🖼️ Quản lý ảnh
- Upload ảnh với drag & drop
- Xem trước ảnh trước khi upload
- Chỉnh sửa tên và thay thế ảnh
- Xóa ảnh với xác nhận

### 🎨 Giao diện
- Responsive design với Bootstrap 5
- Masonry layout cho gallery
- Smooth animations và transitions
- Modal dialogs cho chi tiết ảnh

### ⚡ Trải nghiệm người dùng
- AJAX operations (không reload trang)
- Loading states với spinners
- Flash messages cho feedback
- Validation realtime

## 🔧 Customization

### Thay đổi giới hạn file
Chỉnh sửa trong `create.php` và `edit.php`:
```php
if ($fileSize > 5 * 1024 * 1024) { // 5MB -> thay đổi số này
```

### Thêm format file mới
```php
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
```

### Tùy chỉnh CSS
- Chỉnh sửa `style.css` cho trang create/edit
- Chỉnh sửa `cssindex.css` cho trang chủ
- Sử dụng CSS variables trong `:root` để thay đổi màu sắc

## 🚀 Deployment

### Production Setup
1. Đặt file trong web server directory
2. Cấu hình virtual host
3. Thiết lập HTTPS
4. Tối ưu PHP settings:
   ```ini
   upload_max_filesize = 5M
   post_max_size = 5M
   max_execution_time = 30
   ```

### Security Checklist
- [ ] Thay đổi database credentials
- [ ] Thiết lập file permissions
- [ ] Bật error logging
- [ ] Tắt display_errors trong production
- [ ] Cấu hình backup database

## 📊 Database Schema

```sql
Table: images
+------------+--------------+------+-----+-------------------+
| Field      | Type         | Null | Key | Default           |
+------------+--------------+------+-----+-------------------+
| id         | int          | NO   | PRI | NULL              |
| name       | varchar(255) | NO   |     | NULL              |
| filename   | varchar(255) | NO   |     | NULL              |
| created_at | timestamp    | NO   |     | CURRENT_TIMESTAMP |
| updated_at | timestamp    | NO   |     | CURRENT_TIMESTAMP |
+------------+--------------+------+-----+-------------------+
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Liên hệ

- **LinkedIn**: [minhquang2604](https://linkedin.com/in/minhquang2604)
- **GitHub**: [Your GitHub Profile]

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

---

**Enjoy coding! 🎉**
