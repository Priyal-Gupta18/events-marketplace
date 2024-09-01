<?php
session_start();

include('includes/db.php');
$activePage = 'create_service.php';
include('includes/navbar.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

// Fetch category for the seller
$seller_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.name AS category_name FROM seller_categories sc 
                        JOIN categories c ON sc.category_id = c.id 
                        WHERE sc.seller_id = ?");
$stmt->execute([$seller_id]);
$categoryRow = $stmt->fetch(PDO::FETCH_ASSOC);
if ($categoryRow) {
    $category = $categoryRow['category_name'];
} else {
    $category = ''; // Default category if not found
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_service'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Limit description to 150 words
    $description = implode(' ', array_slice(str_word_count($description, 1), 0, 150));

    // Check if file upload is successful
    if ($image['error'] !== UPLOAD_ERR_OK) {
        $errorMessage = "Error uploading image: ";
        switch ($image['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $errorMessage .= "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $errorMessage .= "The uploaded file exceeds the maximum file size allowed.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $errorMessage .= "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $errorMessage .= "No file was uploaded.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errorMessage .= "Missing a temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $errorMessage .= "Failed to write file to disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $errorMessage .= "A PHP extension stopped the file upload.";
                break;
            default:
                $errorMessage .= "Unknown error.";
                break;
        }
    } else {
        $image_name = uniqid() . '_' . basename($image['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedExtensions)) {
            $errorMessage = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        } elseif (!move_uploaded_file($image['tmp_name'], $target_file)) {
            $errorMessage = "Error moving uploaded file.";
        } else {
            // Save image path relative to uploads folder
            $image_path = "uploads/" . $image_name;

            // Insert service into database
            $stmt = $conn->prepare("INSERT INTO services (seller_id, title, description, price, category, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$seller_id, $title, $description, $price, $category, $image_path]);
            $successMessage = "Service created successfully.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/create_service.css">
    <title>Create New Service</title>
</head>
<body>
<main>

<section>
    <?php if (isset($successMessage)) : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <h2>Create New Service</h2>

    <form class="create-service-form" method="post" action="" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="price">Price per hour (INR):</label>
        <input type="number" name="price" id="price" required>

        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">

        <label for="image">Service Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit" name="create_service">Create Service</button>
    </form>
</section>
</main>
<!-- <?php include('includes/footer.php'); ?> -->

</body>
</html>