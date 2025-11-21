<?php
include "db.php";
include "includes/header.php";

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i",$order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<h2 class="page-title">Order Confirmed</h2>

<div style="padding:30px; text-align:center;">
    <p>Thank you! Your order <strong>#<?= $order['id'] ?></strong> has been received.</p>
    <p>Status: <strong><?= htmlspecialchars($order['status']) ?></strong></p>

    <a href="index.php" class="btn">Continue Shopping</a>
</div>

<?php include "includes/footer.php"; ?>