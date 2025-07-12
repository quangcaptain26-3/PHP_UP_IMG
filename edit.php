<?php
session_start();
include_once("connect.php");

// Kiểm tra ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Lấy dữ liệu hiện tại
$query = "SELECT * FROM images WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Ảnh không tồn tại!";
    exit;
}

$row = mysqli_fetch_assoc($result);
$currentName = $row['name'];
$currentFile = $row['filename'];
$imageUrl = "uploads/" . $currentFile;

// Xử lý form submit
if (isset($_POST['submit'])) {
    $newName = mysqli_real_escape_string($conn, $_POST['fullname']);

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $newFile = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $newFile;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Xoá file cũ
            if (file_exists("uploads/" . $currentFile)) {
                unlink("uploads/" . $currentFile);
            }

            $updateQuery = "UPDATE images SET name = '$newName', filename = '$newFile' WHERE id = $id";
        } else {
            $_SESSION['error'] = "Upload ảnh mới thất bại!";
            header("Location: edit.php?id=$id");
            exit;
        }
    } else {
        $updateQuery = "UPDATE images SET name = '$newName' WHERE id = $id";
    }

    mysqli_query($conn, $updateQuery);
    $_SESSION['success'] = "✅ Cập nhật ảnh thành công!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>📝 Chỉnh sửa ảnh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <!-- Thông báo thành công -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Thông báo lỗi (nếu có) -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container py-5">
        <h2 class="mb-4 fw-bold">📝 Chỉnh sửa ảnh</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Tên người upload:</label>
                <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($currentName) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh hiện tại:</label><br>
                <img src="<?= $imageUrl ?>" alt="<?= $currentName ?>" class="img-thumbnail" style="max-width: 200px;">
            </div>

            <div class="mb-3">
                <label class="form-label">Thay ảnh mới (tuỳ chọn):</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" name="submit" class="btn btn-success">💾 Lưu thay đổi</button>
            <a href="index.php" class="btn btn-secondary">↩️ Quay lại</a>
        </form>
    </div>

    <!-- Bootstrap JS + Auto-hide alert -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const alertBox = document.getElementById("successAlert");
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.remove("show");
                alertBox.classList.add("hide");
            }, 4000);
        }
    </script>

</body>

</html>