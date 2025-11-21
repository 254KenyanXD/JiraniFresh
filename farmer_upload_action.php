<?php
session_start();
include "db.php";

// HARD-CODE FARMER ID FOR NOW (you can replace with login later)
$farmer_id = 1;

// Upload image
$target_dir = "uploads/";
$filename = time() . "_" . basename($_FILES["image"]["name"]);
$target_file = $target_dir . $filename;

move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// Insert into DB
$name = $_POST['name'];
$cat = $_POST['category'];
$price = $_POST['price'];
$desc = $_POST['description'];

$sql = "INSERT INTO farmer_products (farmer_id, name, category, price, description, image)
        VALUES ($farmer_id, '$name', '$cat', $price, '$desc', '$target_file')";

$conn->query($sql);

header("Location: farmer_products.php");
exit();
?>