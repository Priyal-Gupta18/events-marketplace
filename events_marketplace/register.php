<?php
session_start();

include('includes/db.php');

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userType = isset($_POST['user_type']) && ($_POST['user_type'] === 'seller') ? 'seller' : 'buyer';
    $category = ($userType === 'seller' && isset($_POST['category'])) ? $_POST['category'] : null;

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $password, $userType]);

    // Insert seller's category into the database if applicable
    if ($userType === 'seller' && !empty($category)) {
        $userId = $conn->lastInsertId();
        $stmt = $conn->prepare("INSERT INTO seller_categories (seller_id, category_id) VALUES (?, ?)");
        $stmt->execute([$userId, $category]);
    }

    // Redirect to login page after successful registration
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>

<!-- Include the navbar -->
<?php include('includes/navbar.php'); ?>
<main>
<section>
    <h2>Register</h2>
    <div class="form-container">
        <div class="registration-form">
            <?php if (isset($errorMessage)) : ?>
                <p class="error"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <!-- Registration form -->
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <!-- User Type dropdown -->
                <label for="user_type">User Type:</label>
                <select name="user_type" id="user_type" required>
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>

                <!-- Seller Category dropdown (hidden by default) -->
                <div id="category_dropdown" style="display: none;">
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="">Select Category</option>
                        <!-- PHP code to populate categories dynamically -->
                        <?php
                        $stmt = $conn->query("SELECT * FROM categories");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="register">Register</button>
            </form>
            <!-- Login link -->
            <p>Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
</section>           
</main>

<!-- Include the footer -->
<?php include('includes/footer.php'); ?>

<!-- JavaScript to show/hide category dropdown -->
<script>
    document.getElementById('user_type').addEventListener('change', function() {
        var categoryDropdown = document.getElementById('category_dropdown');
        if (this.value === 'seller') {
            categoryDropdown.style.display = 'block';
        } else {
            categoryDropdown.style.display = 'none';
        }
    });
</script>

</body>
</html>
