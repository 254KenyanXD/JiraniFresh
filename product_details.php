<?php
include "db.php";
include "includes/header.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "<p style='padding:40px'>Product not found.</p>";
    include "includes/footer.php";
    exit;
}
?>

<section class="product-detail-section">
    <div class="detail-grid">
        <div class="detail-image">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="detail-info">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p class="category"><?= htmlspecialchars($product['category']) ?></p>
            <p class="price">KSH <?= $product['price'] ?></p>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <form action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <label>Quantity</label>
                <input type="number" name="qty" value="1" min="1" style="width:80px;margin-right:10px;">
                <button type="submit" class="btn add-cart-btn">Add to Cart</button>
            </form>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>