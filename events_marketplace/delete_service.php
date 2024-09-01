<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['service_id'])) {
    $serviceId = $_GET['service_id'];
    
    // Fetch service details
    $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$serviceId]);
    $service = $stmt->fetch();

    // Check if the service belongs to the logged-in seller
    if ($service && $service['seller_id'] == $_SESSION['user_id']) {
        // Delete the service from the database
        $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$serviceId]);

        // Redirect back to the seller's dashboard after deleting
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect to the seller's dashboard if the service doesn't belong to them
        header("Location: dashboard.php");
        exit();
    }
} else {
    // Redirect to the seller's dashboard if no service_id is provided
    header("Location: dashboard.php");
    exit();
}
?>
