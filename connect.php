<?php
// Thông tin kết nối CSDL
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "up_img";

/**
 * PHẦN 1: BẬT CHẾ ĐỘ BÁO LỖI
 * Dòng này yêu cầu MySQLi tự động ném ra một Exception (lỗi) khi có sự cố.
 * Điều này giúp chúng ta không cần phải viết if($conn->error) ở khắp nơi.
 */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    /**
     * PHẦN 2: KẾT NỐI THEO PHONG CÁCH LẬP TRÌNH HƯỚNG ĐỐI TƯỢNG (OOP)
     * Đây là cách làm hiện đại và được ưa chuộng hơn so với mysqli_connect().
     */
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    /**
     * PHẦN 3: THIẾT LẬP BỘ KÝ TỰ (CHARACTER SET)
     * Cực kỳ quan trọng để đảm bảo tiếng Việt có dấu và các ký tự đặc biệt (kể cả emoji)
     * được hiển thị và lưu trữ chính xác. Luôn sử dụng 'utf8mb4'.
     */
    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    /**
     * PHẦN 4: XỬ LÝ LỖI MỘT CÁCH CHUYÊN NGHIỆP
     * Thay vì dùng die() và hiển thị lỗi kỹ thuật cho người dùng,
     * chúng ta "bắt" lỗi lại và có thể xử lý một cách tinh tế hơn.
     */
    // Trong môi trường phát triển (development), bạn có thể in lỗi ra để gỡ rối:
    // error_log("Lỗi kết nối CSDL: " . $e->getMessage());
    
    // Trong môi trường thực tế (production), bạn nên hiển thị một thông báo chung chung.
    http_response_code(500); // Báo lỗi Server Error
    die("Lỗi hệ thống: Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.");
}

// Giờ đây, biến $conn đã sẵn sàng để sử dụng trong các file khác.
?>