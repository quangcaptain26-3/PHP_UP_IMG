<?php
// PHẦN 1: LOGIC PHP - AN TOÀN VÀ RÕ RÀNG
session_start();
include_once("connect.php");

// 1. Kiểm tra và lấy ID một cách an toàn
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];

// 2. Sử dụng PREPARED STATEMENTS để lấy dữ liệu (chống SQL Injection)
$stmt = $conn->prepare("SELECT name, filename FROM images WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Không tìm thấy ảnh, có thể đặt một thông báo lỗi
    $_SESSION['flash_message'] = ['type' => 'danger', 'text' => 'Lỗi: Không tìm thấy ảnh!'];
    header("Location: index.php");
    exit;
}
$image = $result->fetch_assoc();

// 3. Xử lý form khi người dùng gửi (POST request)
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = trim($_POST['name'] ?? '');

    // Xác thực tên
    if (empty($newName)) {
        $errors[] = "Tên ảnh không được để trống.";
    }

    $newFileName = $image['filename']; // Giữ lại tên file cũ mặc định

    // Kiểm tra nếu người dùng tải lên file mới
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            $errors[] = "File mới phải là ảnh (JPG, PNG, GIF).";
        } elseif ($file['size'] > 5 * 1024 * 1024) { // 5MB
            $errors[] = "Kích thước file mới không được vượt quá 5MB.";
        } else {
            // Upload file mới thành công, tạo tên mới và xoá file cũ
            $newFileName = uniqid('', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $uploadPath = 'uploads/' . $newFileName;
            
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Xoá file ảnh cũ nếu tồn tại
                $oldFilePath = 'uploads/' . $image['filename'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            } else {
                $errors[] = "Lỗi khi tải file mới lên.";
            }
        }
    }

    // Nếu không có lỗi, cập nhật CSDL
    if (empty($errors)) {
        $updateStmt = $conn->prepare("UPDATE images SET name = ?, filename = ? WHERE id = ?");
        $updateStmt->bind_param("ssi", $newName, $newFileName, $id);
        
        if ($updateStmt->execute()) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Cập nhật ảnh thành công!'];
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Lỗi khi cập nhật cơ sở dữ liệu.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chỉnh sửa ảnh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold fs-2">📝 Chỉnh sửa ảnh</h1>
                <a href="index.php" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Trở về</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card p-4 shadow-sm">
                    <form action="edit.php?id=<?= $id ?>" method="post" enctype="multipart/form-data" id="edit-form">
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <p class="mb-0"><?= $error ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên ảnh</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($image['name']) ?>">
                                </div>
                                <div class="d-grid gap-2">
                                     <button type="submit" name="submit" class="btn btn-success" id="submit-button">
                                        <span class="button-text"><i class="fa-solid fa-save"></i> Lưu thay đổi</span>
                                        <span class="button-loader d-none">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Đang lưu...
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Thay ảnh mới (tùy chọn)</label>
                                <div class="drop-zone" id="drop-zone">
                                    <div id="image-preview">
                                        <div class="drop-zone__thumb" style="background-image: url('uploads/<?= htmlspecialchars($image['filename']) ?>');" data-label="Ảnh hiện tại"></div>
                                    </div>
                                    <input type="file" name="image" id="image-input" class="drop-zone__input" accept="image/jpeg, image/png, image/gif">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropZone = document.getElementById('drop-zone');
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        // ... (code cho loading button giống hệt create.php) ...
        const editForm = document.getElementById('edit-form');
        const submitButton = document.getElementById('submit-button');
        const buttonText = submitButton.querySelector('.button-text');
        const buttonLoader = submitButton.querySelector('.button-loader');

        dropZone.addEventListener('click', () => imageInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        ['dragleave', 'dragend'].forEach(type => {
            dropZone.addEventListener(type, () => dropZone.classList.remove('drop-zone--over'));
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                updateThumbnail(e.dataTransfer.files[0]);
            }
            dropZone.classList.remove('drop-zone--over');
        });

        imageInput.addEventListener('change', () => {
            if (imageInput.files.length) {
                updateThumbnail(imageInput.files[0]);
            }
        });

        function updateThumbnail(file) {
            // Xoá toàn bộ preview cũ trước khi tạo cái mới
            imagePreview.innerHTML = ''; 

            if (!file) return;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    const thumbElement = document.createElement('div');
                    thumbElement.classList.add('drop-zone__thumb');
                    thumbElement.dataset.label = file.name; // Hiển thị tên file mới
                    thumbElement.style.backgroundImage = `url('${reader.result}')`;
                    imagePreview.appendChild(thumbElement);
                };
                reader.readAsDataURL(file);
            } else {
                 imagePreview.innerHTML = `<div class="alert alert-warning p-2">File không phải là ảnh.</div>`;
            }
        }
        
        editForm.addEventListener('submit', () => {
            buttonText.classList.add('d-none');
            buttonLoader.classList.remove('d-none');
            submitButton.disabled = true;
        });
    });
    </script>
</body>
</html>