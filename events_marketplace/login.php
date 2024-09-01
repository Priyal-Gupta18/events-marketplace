<?php
session_start();

include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check in the admins table
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && $password === $admin['password']) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['user_type'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // If not found in admins table, check in users table
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] === 'seller') {
                header("Location: dashboard.php");
            } elseif ($user['user_type'] === 'buyer') {
                header("Location: services.php");
            } else {
                header("Location: admin_dashboard.php");
            }
            exit();
        } else {
            $errorMessage = 'Invalid email or password.';
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
    <title>Login</title>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<main>
<section id="login">
<h2>Login</h2>
<div class="form-container">
    <div class="login-form">
    

    <?php if (isset($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" name="login">Login</button>
    </form>
    <p>Not Registered Yet? <a href="register.php">Register here</a></p>
    </div>
    </div>
</section>
    </main>
    <?php include('includes/footer.php'); ?>
</body>
</html>

