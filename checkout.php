<?php
session_start();
include "includes/header.php";
include "db.php";
?>

<div class="checkout-background">

    <div class="glass-widget">

        <h2 class="page-title">Checkout</h2>

<?php
if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
    echo "</div></div>";
    include "includes/footer.php";
    exit;
}

echo "<table class='checkout-table'>
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>";

$grand_total = 0;

foreach ($_SESSION['cart'] as $product_id => $qty) {
    $product_id = intval($product_id);
    $sql = "SELECT * FROM products WHERE id=$product_id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();

    $item_total = $row['price'] * $qty;
    $grand_total += $item_total;

    echo "<tr>
            <td><img src='{$row['image']}' class='cart-img'> {$row['name']}</td>
            <td>$qty</td>
            <td>KSH {$row['price']}</td>
            <td>KSH $item_total</td>
        </tr>";
}

echo "</table>";

echo "<h3 style='color:white; margin-top:20px;'>Grand Total: KSH $grand_total</h3>";
echo "<a href='mpesa.php' class='hero-btn' style='margin-top:20px;'>Pay With M-Pesa</a>";
?>

    </div>
</div>

<?php include "includes/footer.php"; ?>