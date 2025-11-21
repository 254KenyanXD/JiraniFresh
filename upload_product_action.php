<?php
include "db.php";

// File upload
$target_dir = "uploads/";
$image_name = time() . "_" . basename($_FILES["image"]["name"]);
$target_file = $target_dir . $image_name;
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// Insert to database
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$description = $_POST['description'];

$sql = "INSERT INTO products (name, category, price, description, image)
        VALUES ('$name', '$category', '$price', '$description', '$target_file')";

$conn->query($sql);

header("Location: admin_products.php");
exit();
?>