<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Image Gallery</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container gallery-container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold">📸 Image Gallery</h2>
      <a href="create.php" class="btn btn-primary">+ Upload Image</a>
    </div>

    <div class="row g-4">
      <?php
        include_once("connect.php");
        $query = "SELECT * FROM images ORDER BY id DESC";
        $result = mysqli_query($conn, $query);
        $i = 0;

        if ($result->num_rows > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["id"];
            $name = htmlspecialchars($row["name"]);
            $filename = htmlspecialchars($row["filename"]);
            $imageUrl = "uploads/" . $filename;
            $modalDelete = "deleteModal" . $i;
            $modalDetail = "detailModal" . $i;
            $i++;

            echo "
              <div class='col-12 col-sm-6 col-md-4 col-lg-3'>
                <div class='card h-100'>
                  <img src='$imageUrl' alt='$name' class='card-img-top'>
                  <div class='card-body text-center'>
                    <p class='card-title'>$name</p>
                    <div class='d-flex justify-content-center gap-2'>
                      <a href='edit.php?id=$id' class='btn btn-sm btn-warning'>📝 Sửa</a>
                      <button class='btn btn-sm btn-info text-white' data-bs-toggle='modal' data-bs-target='#$modalDetail'>🔍 Chi tiết</button>
                      <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#$modalDelete'>🗑️ Xoá</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Xoá -->
              <div class='modal fade' id='$modalDelete' tabindex='-1' aria-labelledby='{$modalDelete}Label' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='{$modalDelete}Label'>Xác nhận xoá</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body text-center'>
                      <img src='$imageUrl' alt='$name' class='img-fluid rounded mb-3' style='max-height:200px;'>
                      <p>Bạn có chắc chắn muốn xoá ảnh <strong>$name</strong> không?</p>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Huỷ</button>
                      <a href='delete.php?id=$id' class='btn btn-danger'>Xoá</a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Chi tiết -->
              <div class='modal fade' id='$modalDetail' tabindex='-1' aria-labelledby='{$modalDetail}Label' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='{$modalDetail}Label'>Thông tin ảnh</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body text-center'>
                      <img src='$imageUrl' alt='$name' class='img-fluid rounded mb-3' style='max-height:200px;'>
                      <p><strong>Tên:</strong> $name</p>
                      <p><strong>Tên file:</strong> $filename</p>
                      <p><strong>ID ảnh:</strong> $id</p>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
                    </div>
                  </div>
                </div>
              </div>
            ";
          }
        } else {
          echo "<p class='text-muted'>Không có ảnh nào.</p>";
        }
      ?>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
