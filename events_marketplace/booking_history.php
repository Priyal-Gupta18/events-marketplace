<?php
session_start();

include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch booking history for the user with status information
$stmt = $conn->prepare("SELECT bh.*, s.title AS service_title, st.name AS status_name FROM booking_history bh JOIN services s ON bh.service_id = s.id JOIN bookings b ON s.id = b.service_id JOIN status st ON b.status_id = st.id WHERE bh.user_id = ?");
$stmt->execute([$userId]);
$bookingHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Booking History</title>
</head>
<body>

<!-- Include the navbar -->
<?php include('includes/navbar.php'); ?>
<main>
<section id="booking_history">
    <h2>Booking History</h2>

    <?php if (!empty($bookingHistory)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Your Booking Contact Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingHistory as $booking) : ?>
                    <tr>
                        <td><?php echo $booking['service_title']; ?></td>
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td><?php echo $booking['contact_number']; ?></td>
                        <td><?php echo $booking['status_name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</section>
    </main>
<!-- Include the footer -->
<?php include('includes/footer.php'); ?>

</body>
</html>
