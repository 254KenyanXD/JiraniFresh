<?php include "includes/header.php"; ?>
<?php include "db.php"; ?>

<div class="farmer-background">

<h2 class="page-title">My Produce Listings</h2>

<div class="product-grid">

<?php
$farmer_id = 1;
$res = $conn->query("SELECT * FROM farmer_products WHERE farmer_id=$farmer_id ORDER BY id DESC");

while ($row = $res->fetch_assoc()):
?>

    <div class="product-card">
        <img src="<?= $row['image'] ?>" class="product-img">

        <div class="product-info">
            <h3><?= $row['name'] ?></h3>
            <p><?= $row['category'] ?></p>
            <p class="price">KSH <?= $row['price'] ?></p>
            <p><?= $row['description'] ?></p>
        </div>
    </div>

<?php endwhile; ?>

</div>

</div>

<?php include "includes/footer.php"; ?>