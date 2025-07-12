# 📸 PHP Image Gallery - Masonry Layout

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow?logo=javascript)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap)](https://getbootstrap.com/)

Một thư viện ảnh hiện đại được xây dựng với PHP và MySQL, có bố cục Masonry tương tác, các hành động được xử lý bằng AJAX và giao diện người dùng sạch sẽ, thân thiện.


---

## ✨ Các tính năng nổi bật

* **Bố cục Masonry:** Tự động sắp xếp các ảnh có kích thước khác nhau một cách thông minh và đẹp mắt.
* **Giao diện đáp ứng (Responsive):** Hiển thị hoàn hảo trên mọi thiết bị từ máy tính để bàn đến điện thoại di động.
* **Tải ảnh kéo-thả:** Giao diện tải ảnh hiện đại, cho phép kéo thả và xem trước ảnh.
* **Tương tác không tải lại trang:** Xóa ảnh và các hành động khác được xử lý bằng AJAX, mang lại trải nghiệm người dùng mượt mà.
* **Modal chi tiết ảnh:** Xem thông tin chi tiết của ảnh trong một modal dùng chung hiệu năng cao.
* **Bảo mật:** Sử dụng Prepared Statements để chống lại các cuộc tấn công SQL Injection.
* **Dễ dàng cài đặt và sử dụng.**

---

## 🛠️ Ngôn ngữ và Công nghệ sử dụng

* **Back-end:** PHP 8+
* **Cơ sở dữ liệu:** MySQL
* **Front-end:**
    * HTML5
    * CSS3
    * JavaScript (ES6+)
    * Bootstrap 5
    * [Masonry.js](https://masonry.desandro.com/) - Cho bố cục
    * [lightgallery.js](https://www.lightgalleryjs.com/) - Cho tính năng xem ảnh (Lightbox)
    * [imagesLoaded](https://imagesloaded.desandro.com/) - Hỗ trợ Masonry

---

## 🚀 Cài đặt và Khởi chạy

Để chạy dự án này trên máy của bạn, hãy làm theo các bước sau:

### **1. Yêu cầu**

* Một môi trường server web như **XAMPP**, **WAMP** hoặc **MAMP**.
* PHP 7.4 hoặc mới hơn.
* MySQL hoặc MariaDB.

### **2. Sao chép dự án**

```bash
git clone [https://github.com/quangcaptain26-3/PHP_UP_IMG.git](https://github.com/quangcaptain26-3/PHP_UP_IMG.git)
cd TEN_REPOSITORY_CUA_BAN
```
### **3. Cài đặt Cơ sở dữ liệu (Database)**

Mở **phpMyAdmin** (hoặc bất kỳ công cụ quản lý CSDL nào), chuyển sang tab **SQL** và chạy các lệnh sau để tạo database và table cần thiết.

```sql
-- 1. Tạo cơ sở dữ liệu với bảng mã utf8mb4 để hỗ trợ tiếng Việt
CREATE DATABASE up_img 

-- 2. Chọn cơ sở dữ liệu vừa tạo
USE up_img;

-- 3. Tạo bảng 'images' để lưu trữ thông tin ảnh
CREATE TABLE images (
    id       INT(11) NOT NULL AUTO_INCREMENT,
    name     VARCHAR(128) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);


```

### **4. Cấu hình kết nối**

Mở file `connect.php` và chỉnh sửa các thông tin kết nối cho phù hợp với môi trường của bạn (thường thì không cần sửa nếu dùng XAMPP mặc định).

```php
<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = ""; // Mật khẩu CSDL của bạn
$dbName = "up_img";

// ... phần còn lại của file ...
?>
```

### **5. Khởi chạy**

* Di chuyển toàn bộ thư mục dự án vào thư mục `htdocs` của XAMPP (hoặc `www` của WAMP).
* Mở trình duyệt và truy cập vào địa chỉ `http://localhost/TEN_THU_MUC_DU_AN`.

---

## 📝 Giấy phép (License)

Dự án này được cấp phép theo **Giấy phép MIT**. Xem chi tiết tại file [LICENSE](LICENSE.md).

<details>
<summary>Nhấn để xem chi tiết Giấy phép MIT</summary>

```
MIT License

Copyright (c) 2025 Minh Quang

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

</details>

---

## 👨‍💻 Tác giả

Được phát triển và duy trì bởi **Minh Quang**.

* **GitHub:** [@quangcaptain26-3](https://github.com/quangcaptain26-3)
* **LinkedIn:** [minhquang2604](https://www.linkedin.com/in/minhquang2604)

Cảm ơn bạn đã ghé thăm! Nếu thấy hữu ích, hãy cho dự án một ⭐ nhé.
