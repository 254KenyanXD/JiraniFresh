<?php
session_start();
include "db.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ADD TO CART (AJAX or normal)
if (isset($_POST["add_to_cart"])) {

    $id = $_POST["product_id"];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    // If AJAX request → return success message
    if (isset($_POST["ajax"])) {
        echo "OK";
        exit();
    }

    // Normal fallback
    header("Location: view_cart.php");
    exit();
}

// UPDATE QUANTITY
if (isset($_POST["action"]) && isset($_POST["product_id"])) {
    $id = $_POST["product_id"];

    if ($_POST["action"] == "increase") {
        $_SESSION['cart'][$id]++;
    } 
    elseif ($_POST["action"] == "decrease") {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    } 
    elseif ($_POST["action"] == "remove") {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: view_cart.php");
    exit();
}
?>