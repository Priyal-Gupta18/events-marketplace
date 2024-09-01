<?php
session_start();

include('includes/db.php');
$activePage = 'book_service.php';
include('includes/navbar.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the service_id is provided in the URL
if (!isset($_GET['service_id'])) {
    header("Location: services.php");
    exit();
}

$serviceId = $_GET['service_id'];

// Fetch service details from the database
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$serviceId]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the service exists
if (!$service) {
    header("Location: services.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Book Service</title>
</head>
<body>

<section id="book_service">
    <h2 class="section-title">Book Service</h2>

    <div class="service-details">
        <h3><?php echo $service['title']; ?></h3>
        <p><?php echo $service['description']; ?></p>
        <p>Price: $<?php echo $service['price']; ?></p>

        <!-- Add a form for booking the service -->
        <form method="post" action="process_booking.php">
    <!-- Include any additional fields you need for the booking -->
    <label for="booking_date">Booking Date:</label>
    <input type="date" name="booking_date" required>
    
    <!-- Add a hidden input field to store the service ID -->
    <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">

    <!-- Add a field for the contact number -->
<label for="contact_number">Contact Number:</label>
<input type="tel" name="contact_number" pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" required>
<!-- <small>Format: 10-digit phone number (e.g., 1234567890)</small> -->


    <button type="submit" name="book_service">Book Now</button>
</form>

    </div>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>
