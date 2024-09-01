<?php
session_start();

include('includes/db.php');

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

// Check if service_id is provided in the URL
if (!isset($_GET['service_id'])) {
    header("Location: dashboard.php");
    exit();
}

$serviceId = $_GET['service_id'];
$userId = $_SESSION['user_id'];

// Fetch the service details from the database
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ? AND seller_id = ?");
$stmt->execute([$serviceId, $userId]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the service belongs to the logged-in seller
if (!$service) {
    header("Location: dashboard.php");
    exit();
}

$successMessage = $errorMessage = '';

// Process form submission for updating the service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_service'])) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';

    // Check if required fields are not empty
    if (!empty($title) && !empty($description) && !empty($price)) {
        // Update the service in the database
        $stmt = $conn->prepare("UPDATE services SET title = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$title, $description, $price, $serviceId]);

        $successMessage = 'Service updated successfully.';
    } else {
        $errorMessage = 'All fields are required.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edit Service</title>
</head>
<body>

<?php include('includes/navbar.php'); ?>

<section>
    <?php if (!empty($successMessage)) : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if (!empty($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
<main>
    <h2>Edit Service</h2>

    <!-- Service update form -->
    <form method="post" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo $service['title']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo $service['description']; ?></textarea>

        <label for="price">Price:</label>
        <input type="text" name="price" id="price" value="<?php echo $service['price']; ?>" required>

        <button type="submit" name="update_service">Update Service</button>
    </form>
</section>
<main>

<?php include('includes/footer.php'); ?>

</body>
</html>
