<?php
include "db.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        
        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') header("Location: admin.php");
        if ($user['role'] == 'farmer') header("Location: farmer.php");
        if ($user['role'] == 'rider') header("Location: rider.php");
        if ($user['role'] == 'customer') header("Location: customer.php");

        exit();
    }
}

echo "Invalid email or password.";