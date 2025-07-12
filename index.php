<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css
">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        include_once("connect.php");
        $query = "SELECT * FROM images";
        $result = mysqli_query($conn, $query);
        echo "<a class='btn btn-info mb-4' href='create.php'>Upload Image</a>";
        if($result->num_rows>0){
            while($row = mysqli_fetch_array($result)){
                $name = $row["name"];
                $filename = $row["filename"];
                $imageUrl = "uploads/" . $filename;
                echo "<div class='profile' mt-4>";
                echo "<img src='$imageUrl' alt='$name'>";
                echo "<h3>$name</h3>";
                echo "</div>";

            }
        }
        ?>
    </div>
</body>
</html>