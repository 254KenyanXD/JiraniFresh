<?php 
session_start();
include "includes/header.php"; 
include "db.php"; 
?>

<div class="products-background">

<h2 class="page-title">Your Shopping Cart</h2>

<div class="cart-container" style="padding:40px;">

<?php
if (empty($_SESSION['cart'])) {
    echo "<p style='color:white; text-align:center;'>Your cart is empty.</p>";
} 
else 
{
    echo "<table class='cart-table' style='width:90%; margin:auto; background:white; padding:20px; border-radius:10px;'>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>";

    $grand_total = 0;

    foreach ($_SESSION['cart'] as $product_id => $qty) {
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $item_total = $row['price'] * $qty;
        $grand_total += $item_total;

        echo "
        <tr>
            <td>
                <img src='{$row['image']}' class='cart-img'>
                <strong>{$row['name']}</strong>
            </td>

            <td>
                <form action='cart.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='product_id' value='$product_id'>
                    <input type='hidden' name='action' value='decrease'>
                    <button class='qty-btn'>-</button>
                </form>

                $qty

                <form action='cart.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='product_id' value='$product_id'>
                    <input type='hidden' name='action' value='increase'>
                    <button class='qty-btn'>+</button>
                </form>
            </td>

            <td>KSH {$row['price']}</td>
            <td>KSH $item_total</td>

            <td>
                <form action='cart.php' method='POST'>
                    <input type='hidden' name='product_id' value='$product_id'>
                    <input type='hidden' name='action' value='remove'>
                    <button class='remove-btn'>REMOVE</button>
                </form>
            </td>
        </tr>";
    }

    echo "</table>";

    echo "<h3 style='color:white; text-align:center; margin-top:20px;'>Grand Total: KSH $grand_total</h3>";
    echo "<div style='text-align:center;'><a href='checkout.php' class='hero-btn'>Proceed to Checkout</a></div>";
}
?>

</div>
</div>

<?php include "includes/footer.php"; ?>