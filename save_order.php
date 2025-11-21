<?php
$customer = $_POST['customer'];
$product  = $_POST['product'];
$qty      = $_POST['qty'];

$data = "Customer: $customer | Product: $product | Quantity: $qty\n";

file_put_contents("orders.txt", $data, FILE_APPEND);

echo "<h2>Order Received!</h2>";
echo "<p>Thank you, $customer. Your order for $qty kg of $product has been recorded.</p>";
echo "<a href='index.php'>Return Home</a>";
?>