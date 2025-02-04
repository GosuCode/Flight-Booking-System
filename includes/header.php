<nav class="navbar">
    <div class="logo">
        <h1>
            <a href="../index.php">Make My Trip</a>
            <span>
                <img src="../assets/logo.svg" alt="Make My Trip">
            </span>
        </h1>
    </div>
    <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="../pages/flights.php">Flights</a></li>
        <li><a href="../pages/book.php">Book</a></li>
        <li><a href="../pages/about_us.php">About Us</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <!-- If user is logged in, show the username, Update Profile link, and Logout link -->
            <li>Welcome,</li>
            <div class="dropdown">
                <button><?php echo htmlspecialchars($_SESSION['username']); ?></button>
                <div class="dropdown-content">
                    <a href="update_user.php"> <img src="../assets/icons/user.svg" alt="user_icon"> Update Profile</a>
                    <a href="../actions/logout_action.php"> <img src="../assets/icons/logout.svg" alt="logout_icon"> Logout</a>
                </div>
            </div>
        <?php else: ?>
            <!-- If user is not logged in, show Login and Register links -->
            <li><a href="../pages/login.php" class="login">
                <button class="secondary-button">Login</button>
            </a></li>
        <?php endif; ?>
    </ul>
</nav>
