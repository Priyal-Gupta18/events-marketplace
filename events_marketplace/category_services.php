<?php
session_start();
include('includes/db.php');
$activePage = 'services.php';
include('includes/navbar.php');

// Retrieve the category parameter from the URL
$category = isset($_GET['category']) ? urldecode($_GET['category']) : '';

if (empty($category)) {
    // Invalid or missing category
    echo '<h2>Invalid or missing category.</h2>';
} else {
    // Fetch services for the specified category
    $stmt = $conn->prepare("SELECT * FROM services WHERE category = ?");
    $stmt->execute([$category]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display services for the category
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <title>Services in <?php echo $category; ?></title>
    </head>
    <body>

    <section id="services">
        <h2 class="section-title">Services in <?php echo $category; ?></h2>

        <div class="service-container">
            <?php if (!empty($services)) : ?>
                <div class="service-box-container">
                    <?php foreach ($services as $service) : ?>
                        <div class="service-box">
                            <h4><?php echo $service['title']; ?></h4>
                            <p><?php echo $service['description']; ?></p>
                            <p>Price: $<?php echo $service['price']; ?></p>
                            <a href="book_service.php?service_id=<?php echo $service['id']; ?>">Book Now</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No services found for this category.</p>
            <?php endif; ?>
        </div>

    </section>

    <?php include('includes/footer.php'); ?>

    </body>
    </html>
    <?php
}

?>
