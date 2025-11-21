<?php include "includes/header.php"; ?>
<?php include "db.php"; ?>

<div class="admin-background">

<h2 class="page-title">Admin: Product List</h2>

<div class="product-list-box">

<table class="admin-table">

<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
while ($row = $result->fetch_assoc()):
?>
<tr>
    <td>
        <img src="<?= $row['image'] ?>" class="admin-list-img">
    </td>

    <td><?= $row['name'] ?></td>
    <td><?= $row['category'] ?></td>
    <td>KSH <?= $row['price'] ?></td>

    <td><a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a></td>
    <td><a href="delete_product.php?id=<?= $row['id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>

</table>

</div>

<div style="text-align:center; margin:20px;">
    <a href="admin_upload.php" class="hero-btn">Upload New Product</a>
</div>

</div>

<?php include "includes/footer.php"; ?>