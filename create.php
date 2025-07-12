<?php
// PHẦN 1: XỬ LÝ LOGIC UPLOAD (KẾT HỢP TỪ UPLOAD.PHP)
session_start(); // Bắt đầu session để lưu trữ thông báo

$errors = [];
$success_message = '';

// Chỉ xử lý khi người dùng gửi form (phương thức POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("connect.php");

    $name = trim($_POST['name'] ?? '');
    
    // 1. Xác thực dữ liệu (Validation)
    if (empty($name)) {
        $errors[] = "Vui lòng nhập tên cho ảnh.";
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Chỉ cho phép tải lên file ảnh (JPG, PNG, GIF).";
        }

        if ($fileSize > 5 * 1024 * 1024) { // Giới hạn 5MB
            $errors[] = "Kích thước file không được vượt quá 5MB.";
        }

    } else {
        $errors[] = "Vui lòng chọn một file ảnh.";
    }

    // 2. Nếu không có lỗi, tiến hành xử lý
    if (empty($errors)) {
        // Tạo tên file mới, duy nhất để tránh trùng lặp
        $newFileName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $uploadPath = 'uploads/' . $newFileName;

        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Lưu thông tin vào CSDL
            $stmt = $conn->prepare("INSERT INTO images (name, filename) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $newFileName);
            
            if ($stmt->execute()) {
                $_SESSION['flash_message'] = "Tải ảnh lên thành công!";
                header("Location: index.php"); // Chuyển hướng về trang chủ
                exit();
            } else {
                $errors[] = "Lỗi khi lưu thông tin vào cơ sở dữ liệu.";
            }
        } else {
            $errors[] = "Có lỗi xảy ra khi tải file lên.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tải ảnh lên</title>
    <!-- Bootstrap 5 & Font Awesome (giống index.php để đồng bộ) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold fs-2">📤 Tải ảnh lên</h1>
                <a href="index.php" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Trở về</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card p-4 shadow-sm">
                    <form action="create.php" method="post" enctype="multipart/form-data" id="upload-form">
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <p class="mb-0"><?= $error ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên ảnh</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ví dụ: Chuyến đi Đà Lạt" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        </div>
                        
                        <!-- PHẦN 2: KHU VỰC UPLOAD TƯƠNG TÁC -->
                        <div class="mb-3">
                            <label class="form-label">Chọn ảnh</label>
                            <div class="drop-zone" id="drop-zone">
                                <span class="drop-zone__prompt">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <p>Kéo & thả file vào đây hoặc nhấn để chọn</p>
                                </span>
                                <input type="file" name="image" id="image-input" class="drop-zone__input" accept="image/jpeg, image/png, image/gif">
                            </div>
                            <div id="image-preview" class="mt-3"></div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary" id="submit-button">
                                <span class="button-text">Tải lên</span>
                                <span class="button-loader d-none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Đang tải...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- PHẦN 3: JAVASCRIPT CHO TÍNH NĂNG KÉO-THẢ VÀ XEM TRƯỚC -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropZone = document.getElementById('drop-zone');
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const uploadForm = document.getElementById('upload-form');
        const submitButton = document.getElementById('submit-button');
        const buttonText = submitButton.querySelector('.button-text');
        const buttonLoader = submitButton.querySelector('.button-loader');

        // Kích hoạt input file khi nhấn vào drop zone
        dropZone.addEventListener('click', () => imageInput.click());

        // Thêm hiệu ứng khi kéo file vào
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        // Bỏ hiệu ứng khi kéo file ra ngoài hoặc huỷ
        ['dragleave', 'dragend'].forEach(type => {
            dropZone.addEventListener(type, () => {
                dropZone.classList.remove('drop-zone--over');
            });
        });

        // Xử lý khi thả file
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                updateThumbnail(e.dataTransfer.files[0]);
            }
            dropZone.classList.remove('drop-zone--over');
        });

        // Xử lý khi chọn file bằng cách nhấn
        imageInput.addEventListener('change', () => {
            if (imageInput.files.length) {
                updateThumbnail(imageInput.files[0]);
            }
        });

        /**
         * Cập nhật ảnh xem trước
         * @param {File} file File ảnh được chọn
         */
        function updateThumbnail(file) {
            // Xoá ảnh preview cũ
            if (imagePreview.querySelector('.drop-zone__thumb')) {
                imagePreview.querySelector('.drop-zone__thumb').remove();
            }

            if (!file) return;

            // Chỉ hiển thị preview cho file ảnh
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    const thumbElement = document.createElement('div');
                    thumbElement.classList.add('drop-zone__thumb');
                    thumbElement.dataset.label = file.name;
                    thumbElement.style.backgroundImage = `url('${reader.result}')`;
                    imagePreview.appendChild(thumbElement);
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = `<div class="alert alert-warning">File không phải là ảnh.</div>`;
            }
        }

        // Hiển thị trạng thái loading khi submit
        uploadForm.addEventListener('submit', () => {
            buttonText.classList.add('d-none');
            buttonLoader.classList.remove('d-none');
            submitButton.disabled = true;
        });
    });
    </script>
</body>
</html>