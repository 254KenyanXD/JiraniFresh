<?php
include "db.php";
include "includes/header.php";

/* Handle upload */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle image
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'uploads/' . time() . '' . preg_replace('/[^a-z0-9\-\.]/i','',basename($_FILES['image']['name']));
        if (move_uploaded_file($_FILES['image']['tmp_name'], $filename)) {
            $imagePath = $conn->real_escape_string($filename);
        } else {
            $imagePath = '';
        }
    } else {
        $imagePath = '';
    }

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, image, description) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssdss", $name, $category, $price, $imagePath, $description);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit;
}

/* Handle deletion */
if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    // delete image path first
    $res = $conn->query("SELECT image FROM products WHERE id=$del_id");
    if ($res && $row = $res->fetch_assoc()) {
        if (!empty($row['image']) && file_exists($row['image'])) {
            @unlink($row['image']);
        }
    }
    $conn->query("DELETE FROM products WHERE id=$del_id");
    header("Location: admin.php");
    exit;
}
?>

<section class="admin-section">
    <h2 class="page-title">Admin — Manage Products</h2>

    <div class="admin-grid">
        <div class="admin-card">
            <h3>Add New Product</h3>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <label>Product Name</label>
                <input type="text" name="name" required>

                <label>Category</label>
                <input type="text" name="category">

                <label>Price (KSH)</label>
                <input type="number" step="0.01" name="price" required>

                <label>Description</label>
                <textarea name="description"></textarea>

                <label>Image</label>
                <input type="file" name="image" accept="image/*">

                <button type="submit" name="upload_product" class="btn">Upload Product</button>
            </form>
        </div>

        <div class="admin-card">
            <h3>Existing Products</h3>
            <div class="admin-products">
                <?php
                $res = $conn->query("SELECT * FROM products ORDER BY id DESC");
                while ($p = $res->fetch_assoc()):
                ?>
                <div class="admin-product-row">
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="" class="mini-img">
                    <div class="admin-prod-info">
                        <strong><?= htmlspecialchars($p['name']) ?></strong>
                        <span>KSH <?= $p['price'] ?></span>
                    </div>
                    <div class="admin-actions">
                        <a href="product_details.php?id=<?= $p['id'] ?>" class="small-btn">View</a>
                        <a href="admin.php?delete_id=<?= $p['id'] ?>" class="small-btn danger" onclick="return confirm('Delete product?')">Delete</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>