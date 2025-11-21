// NAVBAR SCROLL EFFECT
window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 50) navbar.classList.add("header-scrolled");
    else navbar.classList.remove("header-scrolled");
});

// LIVE SEARCH + FILTER
document.addEventListener("DOMContentLoaded", () => {

    const searchBox = document.getElementById("searchBox");
    const categoryFilter = document.getElementById("categoryFilter");
    const products = document.querySelectorAll(".product-card");

    function filterProducts() {
        const search = searchBox.value.toLowerCase();
        const category = categoryFilter.value.toLowerCase();

        products.forEach(card => {
            const name = card.dataset.name;
            const cat = card.dataset.category;

            const matchSearch = name.includes(search);
            const matchCategory = category === "" || cat === category;

            if (matchSearch && matchCategory) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }

    searchBox.addEventListener("keyup", filterProducts);
    categoryFilter.addEventListener("change", filterProducts);
});