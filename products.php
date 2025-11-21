<?php include "includes/header.php"; ?>
<?php include "db.php"; ?>

<div class="products-background">

<h2 class="page-title">Fresh Products</h2>

<!-- SEARCH + FILTER BAR -->
<div class="search-filter-bar">
    <input type="text" id="searchBox" placeholder="Search products...">

    <select id="categoryFilter">
        <option value="">All Categories</option>

        <?php
            $cats = $conn->query("SELECT DISTINCT category FROM products");
            while ($c = $cats->fetch_assoc()):
        ?>
            <option value="<?= $c['category'] ?>"><?= $c['category'] ?></option>
        <?php endwhile; ?>
    </select>
</div>


<!-- PRODUCT GRID (ALL products load at once) -->
<div id="productGrid" class="product-grid">

<?php
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()):
?>

    <div class="product-card"
         data-name="<?= strtolower($row['name']) ?>"
         data-category="<?= strtolower($row['category']) ?>">

        <img src="<?= $row['image'] ?>" class="product-img">

        <div class="product-info">
            <h3><?= $row["name"] ?></h3>
            <p class="category"><?= $row["category"] ?></p>
            <p class="price">KSH <?= $row["price"] ?></p>

            <button class="btn add-cart-btn" onclick="addToCart(<?= $row['id'] ?>)">Add to Cart</button>
        </div>

    </div>

<?php endwhile; ?>

</div>


<!-- PAGINATION BUTTONS -->
<div id="pagination" class="pagination"></div>

</div>

<?php include "includes/footer.php"; ?>



<!-- ************** JAVASCRIPT SECTION ************** -->

<script>
// (1) ADD TO CART -- SILENT AJAX
function addToCart(id) {

    const data = new FormData();
    data.append("add_to_cart", true);
    data.append("ajax", true);
    data.append("product_id", id);

    fetch("cart.php", {
        method: "POST",
        body: data
    })
    .then(res => res.text())
    .then(result => {
        if (result === "OK") {
            alert("Item added to cart!");
        }
    });
}



// (2) CLIENT-SIDE PAGINATION
const itemsPerPage = 10;
let currentPage = 1;

const grid = document.getElementById("productGrid");
const cards = Array.from(grid.getElementsByClassName("product-card"));
const pagination = document.getElementById("pagination");


// Show cards for the current page
function paginate() {
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    cards.forEach((card, idx) => {
        if (idx >= start && idx < end) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });

    buildPaginationButtons(cards.length);
}


// Build page buttons
function buildPaginationButtons(totalItems) {
    pagination.innerHTML = "";
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("a");
        btn.href = "#";
        btn.textContent = i;
        btn.className = (i === currentPage ? "active-page" : "");

        btn.onclick = function(e) {
            e.preventDefault();
            currentPage = i;
            paginate();
        };

        pagination.appendChild(btn);
    }
}



// (3) SEARCH + CATEGORY FILTER ACROSS ALL PRODUCTS
document.addEventListener("DOMContentLoaded", () => {
    const searchBox = document.getElementById("searchBox");
    const categoryFilter = document.getElementById("categoryFilter");

    function filterProducts() {
        const searchTerm = searchBox.value.toLowerCase();
        const selectedCat = categoryFilter.value.toLowerCase();

        let visible = [];

        cards.forEach(card => {
            let nameMatch = card.dataset.name.includes(searchTerm);
            let catMatch = (selectedCat === "" || card.dataset.category === selectedCat);

            if (nameMatch && catMatch) {
                visible.push(card);
            }
        });

        // Hide all cards first
        cards.forEach(c => c.style.display = "none");

        // Show filtered cards with pagination
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        visible.forEach((card, i) => {
            if (i >= start && i < end) {
                card.style.display = "block";
            }
        });

        buildPaginationButtons(visible.length);
    }

    searchBox.addEventListener("keyup", () => { currentPage = 1; filterProducts(); });
    categoryFilter.addEventListener("change", () => { currentPage = 1; filterProducts(); });

    paginate();  // Initial load
});
</script>