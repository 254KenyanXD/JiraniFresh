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
            echo "<p style='text-align:center;'>Your cart is empty. Please <a href='products.php' class='hero-btn'>continue shopping</a>.</p>";
            echo "</div></div>";
            include "includes/footer.php";
            exit;
        }
        ?>

        <h3 style="margin-bottom: 15px;">Order Summary</h3>
        <table class="checkout-table">
            <tr>
                <th style='text-align:left;'>Item</th>
                <th style='text-align:center;'>Qty</th>
                <th style='text-align:center;'>Price</th>
                <th style='text-align:center;'>Total</th>
            </tr>

            <?php
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

                    echo "<tr>
                            <td><img src='{$row['image']}' class='cart-img'> {$row['name']}</td>
                            <td>$qty</td>
                            <td>KSH {$display_price}</td>
                            <td>KSH {$display_item_total}</td>
                          </tr>";
                }
            }
            ?>

        </table>

        <h3 style="margin-top:20px; text-align:right;">Grand Total: KSH <?php echo number_format($grand_total, 2); ?></h3>

        <h3 style="margin-top:35px;">Your Details</h3>

        <form action="mpesa.php" method="POST">

            <?php
            // Pass the Grand Total
            ?>
            <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">

            <?php
            // Serialize and encode the cart array to pass all item IDs and quantities
            $serialized_cart = base64_encode(serialize($_SESSION['cart'])); 
            ?>
            <input type="hidden" name="cart_data" value="<?php echo $serialized_cart; ?>">
            <label>Your Name</label>
            <input type="text" name="customer_name" required>

            <label>Phone Number (M-Pesa)</label>
            <input type="text" name="phone" placeholder="07XXXXXXXX" required>

            <label>Delivery Address</label>
            <input type="text" name="address" required>

            <label>Delivery Instructions</label>
            <textarea name="instructions" rows="3"></textarea>

            <button type="submit" class="hero-btn" style="margin-top:20px; width:100%;">
                Pay With M-Pesa
            </button>

        </form>

    </div>

</div>

<?php include "includes/footer.php"; ?>