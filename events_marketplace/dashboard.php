<?php
session_start();
include('includes/db.php');

// Redirect unauthorized users
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Fetch seller's services
$stmt = $conn->prepare("SELECT * FROM services WHERE seller_id = ?");
$stmt->execute([$userId]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch booked services with status information
$stmt = $conn->prepare("SELECT b.*, s.title AS service_title, st.name AS status_name FROM bookings b JOIN services s ON b.service_id = s.id JOIN status st ON b.status_id = st.id WHERE s.seller_id = ?");
$stmt->execute([$userId]);
$bookedServices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Seller Dashboard</title>
</head>
<body>

<?php include('includes/navbar.php'); ?>
<main>
<section id="seller_dashboard">
    <h2>Welcome, <?php echo $user['username']; ?>!</h2>
    <p>This is your dashboard. You can create new services <a href="create_service.php">here</a>.</p>

    <!-- Display Seller's Services -->
    <section id="seller_services">
        <h3>Your Services</h3>
        <?php if (!empty($services)) : ?>
            <table>
                <!-- Table header -->
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    <?php foreach ($services as $service) : ?>
                        <tr>
                            <td><?php echo $service['title']; ?></td>
                            <td><?php echo $service['description']; ?></td>
                            <td><?php echo $service['price']; ?></td>
                            <td><?php echo $service['category']; ?></td>
                            <td>
                                <!-- Links to edit and delete services -->
                                <a href="edit_service.php?service_id=<?php echo $service['id']; ?>">Edit</a>
                                <a href="delete_service.php?service_id=<?php echo $service['id']; ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>You haven't listed any services yet.</p>
        <?php endif; ?>
    </section>

    <!-- Display Booked Services -->
    <section id="booked_services">
        <h3>Booked Services</h3>
        <?php if (!empty($bookedServices)) : ?>
            <table>
                <!-- Table header -->
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Booking Date</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    <?php foreach ($bookedServices as $bookedService) : ?>
                        <tr>
                            <td><?php echo $bookedService['service_title']; ?></td>
                            <td><?php echo $bookedService['booking_date']; ?></td>
                            <td><?php echo $bookedService['contact_number']; ?></td>
                            <td><?php echo $bookedService['status_name']; ?></td>
                            <td>
                            <form id="status_form" action="update_status.php" method="post">
                                <input type="hidden" name="booking_id" value="<?php echo $bookedService['id']; ?>">
                                <select name="status" onchange="submitForm()">
                                <option value="">Select Status</option>
                                <option value="1">Pending</option>
                                <option value="2">Confirmed</option>
                                <option value="3">Cancelled</option>
                                </select>

                            </form>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No services have been booked yet.</p>
        <?php endif; ?>
    </section>
</section>
        </main>

<?php include('includes/footer.php'); ?>

</body>
</html>
<script>
    function submitForm() {
        document.getElementById("status_form").submit();
    }
</script>
