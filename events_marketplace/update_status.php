<?php
session_start();
include('includes/db.php');

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'seller') {
    // Redirect unauthorized users to the login page
    header("Location: login.php");
    exit();
}

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the booking ID and status from the form
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];

    // Update the status in the database
    $stmt = $conn->prepare("UPDATE bookings SET status_id = ? WHERE id = ?");
    $stmt->execute([$new_status, $booking_id]);

    // Redirect back to the dashboard after updating the status
    header("Location: dashboard.php");
    exit();
} else {
    // If the form data is not submitted via POST method, redirect to the dashboard
    header("Location: dashboard.php");
    exit();
}
?>
