<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="services.php" class="nav-link">Available Services</a></li>
        <?php if(isset($_SESSION['user_id'])) : ?>
            <?php if($_SESSION['user_type'] === 'buyer') : ?>
                <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
            <?php elseif($_SESSION['user_type'] === 'seller') : ?>
                <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
            <?php elseif($_SESSION['user_type'] === 'admin') : ?>
                <li class="nav-item"><a href="admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
        <?php else : ?>
            <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>




