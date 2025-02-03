<?php
session_start();
include('actions/login_action.php'); // Include the login action
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Assuming you have style.css in utils folder -->
</head>
<body>
<?php include '../utils/header.php'; ?><!--header content. file found in utils folder-->

    <div class="form-wrapper">
        <h2 class="login-title">Login</h2>
        
        <!-- Display Messages -->
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error-message'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        }
        ?>
        
        <form class="login-form" method="POST" action="../actions/login_action.php">
            <label class="login-label" for="username">Username:</label>
            <input class="login-input" type="text" name="username" id="username" required>

            <label class="login-label" for="password">Password:</label>
            <input class="login-input" type="password" name="password" id="password" required>
            
            <p><a href="password_recovery.php">Fogot password? </a></p>
            <p>Don't have an account? <a href="register.php">Register here!</a></p>
            <button class="primary-button" type="submit">Login</button>
        </form>
        
    </div>
    <?php include '../utils/footer.php'; ?><!--footer content. file found in utils folder-->

</body>
</html>
