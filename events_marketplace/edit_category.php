<?php
session_start();
// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Check if the category ID is provided
if (!isset($_GET['category_id'])) {
    // Redirect back to the admin dashboard if no category ID is provided
    header("Location: admin_dashboard.php");
    exit();
}

$category_id = $_GET['category_id'];

// Fetch category details from the database
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the category exists
if (!$category) {
    // Redirect back to the admin dashboard if the category doesn't exist
    header("Location: admin_dashboard.php");
    exit();
}

// Define variables for success message and error message
$successMsg = '';
$errorMsg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    // Update category details
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Update category in the database
    $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    $result = $stmt->execute([$name, $description, $category_id]);
    if ($result) {
        // If the update operation was successful, display a success message
        $successMsg = "Category details updated successfully.";
    } else {
        // If the update operation failed, display an error message
        $errorMsg = "Failed to update category details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <h1>Edit Category</h1>

    <!-- Display success message if applicable -->
    <?php if ($successMsg): ?>
        <div style="color: green;"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <!-- Display error message if applicable -->
    <?php if ($errorMsg): ?>
        <div style="color: red;"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <!-- Edit Category Form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?category_id=' . $category_id); ?>" method="post">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $category['name']; ?>" placeholder="Category Name" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" placeholder="Description" required><?php echo $category['description']; ?></textarea><br>
        <button type="submit" name="update_category">Save Changes</button>
    </form>
</body>
</html>
