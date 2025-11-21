<?php
include "db.php";
include "includes/header.php";

/* POST: farmer upload */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['farmer_upload'])) {

    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);

    // Image upload
    $filename = '';
    if (!empty($_FILES['image']['name'])) {
        $filename = 'uploads/' . time() . '_' . preg_replace('/[^a-z0-9\.\-]/i', '', basename($_FILES['image']['name']));
        move_uploaded_file($_FILES['image']['tmp_name'], $filename);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, description, image) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssdss", $name, $category, $price, $description, $filename);
    $stmt->execute();
    $stmt->close();

    header("Location: farmer.php");
    exit;
}
?>

<div class="farmer-background">

    <div class="glass-widget">
        <h2 class="page-title" style="color:white;">Upload Produce</h2>

        <form action="farmer.php" method="POST" enctype="multipart/form-data">

            <label>Produce Name</label>
            <input type="text" name="name" required>

            <label>Category</label>
            <input type="text" name="category" required>

            <label>Price (KSH)</label>
            <input type="number" step="0.01" name="price" required>

            <label>Description</label>
            <textarea name="description" rows="3"></textarea>

            <label>Image</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit" name="farmer_upload" class="hero-btn">Upload Produce</button>

        </form>
    </div>

</div>

<?php include "includes/footer.php"; ?>