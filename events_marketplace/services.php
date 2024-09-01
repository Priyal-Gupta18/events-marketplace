<?php
session_start();
include('includes/db.php');
$activePage = 'services.php';
include('includes/navbar.php');

// Fetch all unique service categories from the database
$stmt = $conn->query("SELECT DISTINCT category FROM services");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch services based on the selected category if provided, otherwise fetch all services
if (isset($_GET['category'])) {
    $selectedCategory = $_GET['category'];
    $stmt = $conn->prepare("SELECT * FROM services WHERE category = ?");
    $stmt->execute([$selectedCategory]);
} else {
    $stmt = $conn->query("SELECT * FROM services");
}
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/services.css"> <!-- Add separate CSS file for services -->
    <title>All Services</title>
</head>
<body>
<main>
<section id="services">
    <h2 class="section-title">Available Services</h2>

    <div class="search-sort-container">
        <!-- Search bar -->
        <input type="text" class="search-bar" placeholder="Search Services" id="searchBar">

        <!-- Sort by category options -->
        <select class="sort-options" id="sortOptionsCategory">
            <option value="random">All Categories</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category']; ?>">Sort by <?php echo $category['category']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="service-container">

        <!-- Display services -->
        <div class="service-box-container">
            <?php foreach ($services as $service) : ?>
                <div class="service-box" data-category="<?php echo $service['category']; ?>">
                    <?php if ($service['image']) : ?>
                        <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['title']; ?>">
                    <?php endif; ?>
                    <h4><?php echo $service['title']; ?></h4>
                    <p><?php echo $service['description']; ?></p>
                    <p>Price: $<?php echo $service['price']; ?></p>
                    <a href="book_service.php?service_id=<?php echo $service['id']; ?>">Book Now</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
                
</main>


<script>
    // JavaScript for sorting and filtering services
    document.addEventListener('DOMContentLoaded', function () {
        const searchBar = document.getElementById('searchBar');
        const sortOptionsCategory = document.getElementById('sortOptionsCategory');
        const serviceBoxes = document.querySelectorAll('.service-box');

        // Function to filter services based on search query
        function filterServices(query) {
            const regex = new RegExp(query.trim(), 'i');
            serviceBoxes.forEach(function (box) {
                const title = box.querySelector('h4').textContent;
                const description = box.querySelector('p').textContent;
                if (regex.test(title) || regex.test(description)) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            });
        }

        // Function to apply sorting based on selected category
        function applyCategorySorting() {
            const categoryValue = sortOptionsCategory.value;
            serviceBoxes.forEach(box => {
                if (categoryValue === 'random' || box.dataset.category === categoryValue) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            });
        }

        // Event listener for search bar input
        searchBar.addEventListener('input', function () {
            filterServices(this.value);
        });

        // Event listener for sort options (category)
        sortOptionsCategory.addEventListener('change', applyCategorySorting);

        // Apply initial sorting
        applyCategorySorting();
    });
</script>

</body>
</html>
