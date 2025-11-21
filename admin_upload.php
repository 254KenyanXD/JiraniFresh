<?php include "includes/header.php"; ?>
<?php include "db.php"; ?>

<div class="admin-background">

<h2 class="page-title">Admin: Upload New Product</h2>

<div class="upload-box">

<form action="upload_product_action.php" method="POST" enctype="multipart/form-data">

    <label>Product Name</label>
    <input type="text" name="name" required>

    <label>Category</label>
    <input type="text" name="category" required>

    <label>Price (KSH)</label>
    <input type="number" name="price" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <label>Product Image</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit" class="hero-btn">Upload Product</button>

</form>

</div>

<!-- Link to product list -->
<div style="text-align:center; margin-top:30px;">
    <a href="admin_products.php" class="hero-btn">View Existing Products</a>
</div>

</div>

<?php include "includes/footer.php"; ?>