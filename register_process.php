<?php
include "db.php"; 

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone = $_POST['phone'];
$address = $_POST['address'];
$role = $_POST['role'];

$sql = "INSERT INTO users (fullname, email, password, phone, address, role) 
        VALUES ('$fullname', '$email', '$password', '$phone', '$address', '$role')";

if ($conn->query($sql)) {
    echo "Account created successfully! <a href='login.php'>Login</a>";
} else {
    echo "Error: " . $conn->error;
}