<?php
// 🚨 FIX: Start output buffering immediately. This captures any rogue output
// from included files (like whitespace before header.php) and prevents
// it from being sent until the script finishes.
ob_start(); 

session_start();
// Set headers to aggressively prevent browser caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "includes/header.php";
include "db.php";

// -----------------------------------------------------------------
// PHP Logic for Handling AJAX Add to Cart (from products.php)
// -----------------------------------------------------------------

if (isset($_POST['add_to_cart'], $_POST['ajax'], $_POST['product_id'])) {
    
    $product_id = intval($_POST['product_id']);

    if ($product_id > 0) {
        $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) 
            ? $_SESSION['cart'][$product_id] + 1 
            : 1;

        // Clean the buffer and echo only the success message
        ob_clean(); 
        echo "OK";
        exit(); 
    }
}

// -----------------------------------------------------------------
// PHP Logic to Handle Cart Actions (Increase/Decrease/Remove)
// -----------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['product_id'])) {
    
    $action = $_POST['action'];
    $product_id = intval($_POST['product_id']);

    if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
        
        switch ($action) {
            case 'increase':
                $_SESSION['cart'][$product_id]++;
                break;
            case 'decrease':
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;
            case 'remove':
                unset($_SESSION['cart'][$product_id]);
                break;
        }
        
        header("Location: cart.php");
        exit();
    }
}
// -----------------------------------------------------------------
?>

<div class="products-background">

    <div class="glass-widget">
        <h2 class="page-title">Shopping Cart</h2>

        <?php
        if (empty($_SESSION['cart'])) {
            echo "<p style='text-align:center;'>Your cart is empty.</p>";
        } else {

            // Table Header - Uses correct classes
            echo "<table class='checkout-table' style='margin-top:20px;'>
                    <tr>
                        <th class='item-header'>Item</th>
                        <th class='qty-header'>Qty</th>
                        <th class='price-header'>Price</th>
                        <th class='total-header'>Total</th>
                        <th class='remove-header'>Remove</th>
                    </tr>";

            $grand_total = 0;

            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $sql = "SELECT * FROM products WHERE id=" . intval($product_id);
                $res = $conn->query($sql);
                
                if ($res && $res->num_rows > 0) {
                    $row = $res->fetch_assoc();

                    $item_total = $row['price'] * $qty;
                    $grand_total += $item_total;
                    
                    $display_price = number_format($row['price'], 2);
                    $display_item_total = number_format($item_total, 2);

                    echo "
                    <tr>
                        <td>
                            <img src='{$row['image']}' class='cart-img'>
                            <span>" . htmlspecialchars($row['name']) . "</span>
                        </td>
                        <td>
                            <form method='POST' action='cart.php' class='qty-controls'>
                                <input type='hidden' name='product_id' value='{$product_id}'>
                                <button name='action' value='decrease' class='qty-btn'>-</button>
                                <span style='font-size:1.2rem; color:white;'>$qty</span>
                                <button name='action' value='increase' class='qty-btn'>+</button>
                            </form>
                        </td>
                        <td>KSH {$display_price}</td>
                        <td>KSH {$display_item_total}</td>
                        <td>
                            <form method='POST' action='cart.php' style='text-align:center;'>
                                <input type='hidden' name='product_id' value='{$product_id}'>
                                <input type='hidden' name='action' value='remove'>
                                <button class='remove-btn'>REMOVE</button>
                            </form>
                        </td>
                    </tr>";
                }
            }
            echo "</table>";
            echo "<h3 style='margin-top:20px; text-align:center;'>Grand Total: KSH " . number_format($grand_total, 2) . "</h3>";
            echo "<div style='text-align:center; margin-top:25px;'>
                    <a href='checkout.php' class='hero-btn'>Proceed to Checkout</a>
                  </div>";
        }
        ?>

    </div>

</div>

<?php include "includes/footer.php"; ?>

<?php
// 🚨 FIX: Flush the output buffer, sending all collected content at once.
ob_end_flush(); 
?>