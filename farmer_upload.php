<?php include "includes/header.php"; ?>
<?php include "db.php"; ?>

<div class="farmer-background">

<h2 class="page-title">Advertise Your Produce</h2>

<div class="upload-box">

<form action="farmer_upload_action.php" method="POST" enctype="multipart/form-data">

    <label>Product Name</label>
    <input type="text" name="name" required>

    <label>Category</label>
    <input type="text" name="category" required>

    <label>Price per Unit (KSH)</label>
    <input type="number" name="price" required>

    <label>Description</label>
    <textarea name="description" rows="4"></textarea>

    <label>Product Image</label>
    <input type="file" name="image" required>

    <button type="submit" class="hero-btn">Upload Produce</button>

</form>

</div>

<div style="text-align:center; margin-top:30px;">
    <a href="farmer_products.php" class="hero-btn">View My Listings</a>
</div>

</div>

<?php include "includes/footer.php"; ?>