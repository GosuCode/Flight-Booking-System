<?php
session_start();
include('actions/register_action.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="../js/validation.js"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?><!--header content. file found in utils folder-->
    
    <div class="form-wrapper">
        <h2 class="register-title">Create Account</h2>
        <!-- Display Messages -->
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error-message'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']); // Remove after displaying
        }
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        }
        ?>
        
        <form class="register-form" method="POST" action="../actions/register_action.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <div id="username-error" class="error-message"></div> <!-- Error message for username -->

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <div id="email-error" class="error-message"></div> <!-- Error message for email -->

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <div id="password-error" class="error-message"></div> <!-- Error message for password -->

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <div id="confirm-password-error" class="error-message"></div>

            <div class="password-requirements">
            <p>Password must contain:</p>
            <ul id="password-rules">
                <li id="rule-length">At least 8 characters</li>
                <li id="rule-uppercase">At least 1 uppercase letter</li>
                <li id="rule-special">At least 1 special character</li>
            </ul>
            </div>

            <p>Already hanve an account? <a href="login.php">Login</a></p>

            <button class="primary-button" type="submit">Register</button>
        </form>

    </div>
    <?php include '../includes/footer.php'; ?><!--footer content. file found in utils folder-->

</body>
</html>
