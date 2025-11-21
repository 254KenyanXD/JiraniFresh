<?php include "includes/header.php"; ?>
<?php include "data/products.php"; ?>

<h2>Place an Order</h2>

<form action="save_order.php" method="POST" class="order-form">
    <label>Your Name</label>
    <input type="text" name="customer" required>

    <label>Select Product</label>
    <select name="product" required>
        <?php foreach($products as $p): ?>
            <option value="<?= $p['name'] ?>"><?= $p['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Quantity (kg)</label>
    <input type="number" name="qty" min="1" required>

    <button type="submit" class="btn">Submit Order</button>
</form>

<?php include "includes/footer.php"; ?>