<?php
include_once("connect.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy tên file từ CSDL
    $query = "SELECT filename FROM images WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $filename = $row['filename'];
        $filePath = "uploads/" . $filename;

        // Xoá file trên server
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Xoá record trong CSDL
        $deleteQuery = "DELETE FROM images WHERE id = $id";
        mysqli_query($conn, $deleteQuery);
    }
}

header("Location: index.php");
exit;
