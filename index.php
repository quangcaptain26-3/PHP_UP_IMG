<?php
// Phần logic PHP ở đầu file, truy vấn CSDL và lấy dữ liệu
include_once("connect.php");
$query = "SELECT * FROM images ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$images = [];
if ($result && $result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Xử lý dữ liệu an toàn trước khi hiển thị
        $row['name'] = htmlspecialchars($row['name']);
        $row['filename'] = htmlspecialchars($row['filename']);
        $row['imageUrl'] = "uploads/" . $row['filename'];
        $images[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thư viện ảnh</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="cssindex.css" />
</head>
<body>
    <header class="py-4 shadow-sm bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold fs-2 mb-0">📸 Thư viện ảnh</h1>
                <a href="create.php" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Tải lên</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div id="masonry-container">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <?php 
                        // Tạo ID duy nhất cho modal xoá của từng ảnh
                        $modalDeleteId = "deleteModal-" . $image['id']; 
                    ?>
                    
                    <div class='col-12 col-sm-6 col-md-4 grid-item' id="image-card-<?= $image['id'] ?>">
                        <article class="card shadow-sm mb-4">
                            <img src="<?= $image['imageUrl'] ?>" alt="<?= $image['name'] ?>" class="card-img-top">
                            <div class='card-body text-center'>
                                <h5 class='card-title' title="<?= $image['name'] ?>"><?= $image['name'] ?></h5>
                                <div class='d-flex justify-content-center gap-2 mt-3'>
                                    <a href='edit.php?id=<?= $image['id'] ?>' class='btn btn-sm btn-outline-warning' title="Sửa"><i class="fa-solid fa-pencil"></i></a>
                                    <button class='btn btn-sm btn-outline-info' 
                                            data-bs-toggle='modal' 
                                            data-bs-target='#imageDetailModal' 
                                            data-image-url="<?= $image['imageUrl'] ?>"
                                            data-image-name="<?= $image['name'] ?>"
                                            data-image-filename="<?= $image['filename'] ?>"
                                            data-image-id="<?= $image['id'] ?>"
                                            title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class='btn btn-sm btn-outline-danger' data-bs-toggle='modal' data-bs-target='#<?= $modalDeleteId ?>' title="Xoá"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class='modal fade' id='<?= $modalDeleteId ?>' tabindex='-1' aria-labelledby='<?= $modalDeleteId ?>Label' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <form method="POST" class="delete-form">
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='<?= $modalDeleteId ?>Label'>Xác nhận xoá</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body text-center'>
                                        <img src='<?= $image['imageUrl'] ?>' alt='<?= $image['name'] ?>' class='img-fluid rounded mb-3' style='max-height:200px;'>
                                        <p>Bạn có chắc chắn muốn xoá ảnh <strong><?= $image['name'] ?></strong> không?</p>
                                        <input type="hidden" name="id" value="<?= $image['id'] ?>">
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Huỷ</button>
                                        <button type='submit' class='btn btn-danger'>Đồng ý xoá</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center p-5 bg-light rounded">
                         <p class='fs-5 text-muted'>Chưa có ảnh nào trong thư viện.</p>
                         <a href="create.php" class="btn btn-primary mt-2">Tải lên ảnh đầu tiên của bạn!</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div class='modal fade' id='imageDetailModal' tabindex='-1' aria-labelledby='imageDetailModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='imageDetailModalLabel'>Chi tiết ảnh</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <img src="" alt="Image detail" class="img-fluid rounded mb-3 w-100" id="modal-image-content">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Tên file:</strong> <span id="modal-image-filename"></span></li>
                        <li class="list-group-item"><strong>ID:</strong> <span id="modal-image-id"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <a href="#" id="modal-edit-button" class="btn btn-warning">📝 Sửa ảnh này</a>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // --- 1. KHỞI TẠO MASONRY LAYOUT ---
        const grid = document.getElementById('masonry-container');
        imagesLoaded(grid, function() {
            const msnry = new Masonry(grid, {
                itemSelector: '.grid-item',
                percentPosition: true,
                gutter: 16
            });
        });
        
        // --- 2. LOGIC CHO MODAL CHI TIẾT (DÙNG CHUNG) ---
        const detailModal = document.getElementById('imageDetailModal');
        if(detailModal) {
            detailModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const imageUrl = button.getAttribute('data-image-url');
                const imageName = button.getAttribute('data-image-name');
                const imageFilename = button.getAttribute('data-image-filename');
                const imageId = button.getAttribute('data-image-id');
                
                detailModal.querySelector('.modal-title').textContent = imageName;
                detailModal.querySelector('#modal-image-content').src = imageUrl;
                detailModal.querySelector('#modal-image-content').alt = imageName;
                detailModal.querySelector('#modal-image-filename').textContent = imageFilename;
                detailModal.querySelector('#modal-image-id').textContent = imageId;
                detailModal.querySelector('#modal-edit-button').href = `edit.php?id=${imageId}`;
            });
        }

        // --- 3. LOGIC XỬ LÝ XOÁ BẰNG AJAX ---
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                
                const formData = new FormData(this);
                const imageId = formData.get('id');
                const cardContainer = document.getElementById(`image-card-${imageId}`);

                fetch('delete.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modalEl = this.closest('.modal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                        
                        if (cardContainer) {
                            cardContainer.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                            cardContainer.style.opacity = '0';
                            cardContainer.style.transform = 'scale(0.8)';
                            setTimeout(() => {
                                cardContainer.remove();
                                // Yêu cầu Masonry sắp xếp lại layout sau khi xoá một item
                                new Masonry(grid).layout();
                            }, 500);
                        }
                    } else {
                        alert('Lỗi: ' + (data.message || 'Không thể xoá ảnh.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi nghiêm trọng xảy ra, vui lòng thử lại.');
                });
            });
        });

    });
    </script>
</body>
</html>