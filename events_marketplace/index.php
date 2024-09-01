<?php
session_start();
// Include the database connection file
include('includes/db.php');

// Fetch all unique service categories from the database
$stmt = $conn->query("SELECT DISTINCT category FROM services");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Event Marketplace</title>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="scrollAnimations.js"></script>

</head>
<body>

<?php include('includes/navbar.php'); ?>

<main>
    <header id="header" class="hero hidden">
        <div class="container">
            <h1>Welcome to Event Marketplace</h1>
            <p>Your one-stop destination for all your event planning needs.</p>
            
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="logout.php" class="btn btn-outline">Logout</a>
            <?php else : ?>
                <a href="register.php" class="btn btn-outline">Register</a>
                <a href="login.php" class="btn btn-outline">Login</a>
            <?php endif; ?>
        </div>
    </header>
    <section id="about" class="about hidden">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Us</h2>
                    <p>This Event Marketplace is designed to simplify your event planning process. Whether you're organizing a wedding, birthday party, or corporate event, we've got you covered. Explore a wide range of services, connect with experienced vendors, and make your event a success.</p>
                </div>
                <div class="about-image">
                    <img src="images/ab.jpg" alt="Service Image">
                </div>
            </div>
        </div>
    </section>
 
  <section id="services" class="services hidden">
    <div class="container">
        <h2>Our Services</h2>
        <div class="service-categories">
            <?php
            // Fetch categories with images and descriptions
            $stmt = $conn->query("SELECT * FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $category) :
            ?>
                <div class="service-category">
                    <h3><?php echo $category['name']; ?></h3>
                    <?php if ($category['image']) : ?>
                        <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>">
                    <?php endif; ?>
                    <?php if ($category['description']) : ?>
                        <p><?php echo $category['description']; ?></p>
                    <?php endif; ?>
                    <a href="services.php?category=<?php echo urlencode($category['name']); ?>" class="btn btn-outline">Browse Category</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



</main>
   
<?php include('includes/footer.php'); ?>


</body>
</html>
