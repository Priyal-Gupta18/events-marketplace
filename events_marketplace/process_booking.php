<?php
session_start();

include('includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_service'])) {
    // Get the user ID, service ID, booking date, and contact number from the form
    $userId = $_SESSION['user_id'];
    $serviceId = $_POST['service_id'];
    $bookingDate = $_POST['booking_date'];
    $contactNumber = $_POST['contact_number']; // New field

    // Insert booking details into the database
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, booking_date, contact_number) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $serviceId, $bookingDate, $contactNumber]);

    // Insert booking details into the booking_history table
$stmt = $conn->prepare("INSERT INTO booking_history (user_id, service_id, booking_date, contact_number) VALUES (?, ?, ?, ?)");
$stmt->execute([$userId, $serviceId, $bookingDate, $contactNumber]);

    // Redirect to a success page or display a success message
    header("Location: booking_success.php");
    exit();
} else {
    // If the form is not submitted, redirect to the home page or display an error message
    header("Location: index.php");
    exit();
}
