<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css
">
    <link rel="stylesheet" href="style.css">
    <title>Upload Images</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Upload Image</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input class="form-control mt-4" type="text" name="fullname" id="" placeholder="Enter your name:">
            <input class="form-control mt-4" type="file" name="image" id="">
            <input class="btn btn-primary mt-4" type="submit" value="Upload" name="submit">
        </form>
    </div>
</body>

</html>