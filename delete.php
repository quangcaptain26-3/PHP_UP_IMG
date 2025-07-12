<?php
// PHẦN 1: THIẾT LẬP ĐỂ TRẢ VỀ JSON
// Báo cho trình duyệt biết rằng file này sẽ trả về dữ liệu dạng JSON
header('Content-Type: application/json');
include_once("connect.php");

// Khởi tạo một mảng để chứa kết quả trả về
$response = [
    'success' => false,
    'message' => 'Yêu cầu không hợp lệ hoặc thiếu ID.'
];

// PHẦN 2: XỬ LÝ YÊU CẦU AN TOÀN
// Chỉ chấp nhận phương thức POST và ID là một con số
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu:
    // Hoặc tất cả thành công, hoặc không có gì thay đổi.
    $conn->begin_transaction();

    try {
        // BƯỚC 1: Lấy tên file an toàn bằng Prepared Statement
        $stmt = $conn->prepare("SELECT filename FROM images WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $image = $result->fetch_assoc();
            $filename = $image['filename'];
            
            // BƯỚC 2: Xoá record trong CSDL an toàn bằng Prepared Statement
            $deleteStmt = $conn->prepare("DELETE FROM images WHERE id = ?");
            $deleteStmt->bind_param("i", $id);
            
            if ($deleteStmt->execute()) {
                // BƯỚC 3: Nếu xoá CSDL thành công, tiến hành xoá file vật lý
                $filePath = 'uploads/' . $filename;
                if (file_exists($filePath)) {
                    unlink($filePath); // Xoá file khỏi thư mục uploads
                }
                
                // Nếu tất cả các bước trên thành công, xác nhận transaction
                $conn->commit();
                $response = ['success' => true];

            } else {
                // Ném ra lỗi nếu câu lệnh delete thất bại
                throw new Exception('Lỗi khi thực thi lệnh xoá trong CSDL.');
            }
            $deleteStmt->close();

        } else {
            $response['message'] = 'Không tìm thấy ảnh với ID này.';
        }
        $stmt->close();
        
    } catch (Exception $e) {
        // Nếu có bất kỳ lỗi nào xảy ra, rollback lại transaction
        $conn->rollback();
        $response['message'] = 'Đã có lỗi xảy ra: ' . $e->getMessage();
    }
}

// PHẦN 3: TRẢ KẾT QUẢ VỀ CHO JAVASCRIPT
// Dù thành công hay thất bại, luôn echo ra mảng $response đã được mã hoá JSON
echo json_encode($response);
exit;