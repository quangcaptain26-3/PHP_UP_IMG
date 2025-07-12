<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload Image</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h3 class="mb-4 text-center">📤 Upload Image</h3>
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="fullname" class="form-label">Your Name</label>
              <input type="text" class="form-control" name="fullname" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Choose Image</label>
              <input type="file" class="form-control" name="image" required>
            </div>
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-primary">Upload</button>
            </div>
          </form>
          <div class="mt-4 text-center">
            <a href="index.php" class="btn btn-link">← Back to Gallery</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
