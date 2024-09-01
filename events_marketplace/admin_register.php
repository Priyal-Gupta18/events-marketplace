<!-- admin_register.php -->

<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Handle form submission
    // Validate and process form data here
    // Insert admin data into the database
    // Redirect to admin dashboard or another appropriate page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Registration</title>
</head>
<body>

<?php include('includes/navbar.php'); ?>

<section id="admin_register">
    <h2>Admin Registration</h2>
    
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit" name="register">Register</button>
    </form>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>
