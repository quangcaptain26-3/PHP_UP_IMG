<?php
include_once("connect.php");
if ($_POST["submit"]) {
    $fullName = $_POST["fullname"];
    $fileName = $_FILES["image"]["name"];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowTypes = array("jpg", "png", "jpeg", "gif", "webp");
    $tempName = $_FILES["image"]["tmp_name"];
    $targetpath = "uploads/" . $fileName;
    if (in_array($ext, $allowTypes)) {
        if (move_uploaded_file($tempName, $targetpath)) {
            $query = "INSERT INTO images(name, filename) VALUES('$fullName', '$fileName')";
            if (mysqli_query($conn, $query)) {
                header("Location: index.php");
            } else {
                echo "Error";
            }
        } else {
            echo "Error";
        }
    } else {
        echo "Your file type is not allowed";
    }
}
