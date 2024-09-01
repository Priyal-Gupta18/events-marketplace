<?php
session_start();

// Checks if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/db.php');
$activePage = 'booking_success.php';
include('includes/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Booking Success</title>
</head>
<body>
<main>

<section id="booking-success">
    <h2>Booking Successful!</h2>
    <p>Your service has been successfully booked. Thank you for choosing our platform.</p>
    <a href="services.php">Browse More</a>
</section>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
