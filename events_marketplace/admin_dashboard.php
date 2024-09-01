<?php
session_start();
// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');
include('includes/navbar.php');

// Define variables for success message and error message
$successMsg = '';
$errorMsg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    // Process form data
    $name = $_POST['name'];
    $description = $_POST['description'];

    // File upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($fileName)) {
        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Insert category into database
                $stmt = $conn->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
                $result = $stmt->execute([$name, $description, $targetFilePath]);
                if ($result) {
                    // If the insertion was successful, display a success message
                    $successMsg = "Category added successfully.";
                } else {
                    // If the insertion failed, display an error message
                    $errorMsg = "Failed to add category.";
                }
            } else {
                $errorMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $errorMsg = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
        }
    } else {
        $errorMsg = "Please select a file to upload.";
    }
}

// Fetch all categories
$stmt = $conn->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
    <h1>Admin Dashboard</h1>

    <!-- Display success message if applicable -->
    <?php if ($successMsg): ?>
        <div style="color: green;"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <!-- Display error message if applicable -->
    <?php if ($errorMsg): ?>
        <div style="color: red;"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <!-- Add Category Form -->
    <h2>Add Category</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Category Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="file" name="image" required><br>
        <button type="submit" name="add_category">Add Category</button>
    </form>

    <!-- List of Categories -->
    <section class="CategoriesList">
    <h2>Categories</h2>
    <table>
        <tr>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?php echo $category['name']; ?></td>
                <td>
                    <!-- Edit Category Button -->
                    <button class="edit-button" onclick="location.href='edit_category.php?category_id=<?php echo $category['id']; ?>'">Edit</button>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
        </main>
</body>
</html>
