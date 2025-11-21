<?php
include "db.php";
include "includes/header.php";

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i",$order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    echo "<p style='padding:40px'>Order not found.</p>";
    include "includes/footer.php";
    exit;
}

/* Mark paid if form submitted */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simulate_pay'])) {
    $stmt = $conn->prepare("UPDATE orders SET status='paid' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: order_success.php?order_id=$order_id");
    exit;
}
?>

<h2 class="page-title">MPESA Payment (Mock)</h2>

<div style="padding:30px; text-align:center;">
    <p>Order #: <strong><?= $order['id'] ?></strong></p>
    <p>Total: <strong>KSH <?= number_format($order['total'],2) ?></strong></p>

    <p>To simulate payment, press the button below.</p>

    <form method="POST">
        <button type="submit" name="simulate_pay" class="btn hero-btn">Simulate MPESA Payment</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>