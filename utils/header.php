<nav class="navbar">
    <div class="logo">
        <h1><a href="../index.php">Totoro</a></h1>
    </div>
    <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="about_us.php">About Us</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <!-- If user is logged in, show the username, Update Profile link, and Logout link -->
            <li><a href="#">Welcome,</a></li>
            <div class="dropdown">
                <button><?php echo htmlspecialchars($_SESSION['username']); ?></button>
                <div class="dropdown-content">
                <a href="#">View Profile</a>
                <a href="update_user.php">Update Profile</a>
                <a href="../actions/logout_action.php">Logout</a>
            </div>
    </div>
        <?php else: ?>
            <!-- If user is not logged in, show Login and Register links -->
            <li><a href="../pages/login.php" class="login">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
