<?php
session_start();
include('../config.php'); // Include the database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate input fields
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Both fields are required!";
        header("Location: ../pages/login.php");
        exit();
    }

    // Prepare SQL to check for the user in the database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // If user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        // Check if password matches
        if (password_verify($password, $db_password)) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['success_message'] = "Login successful!";
            
            // Redirect to the homepage
            header("Location: ../pages/services.php");
        } else {
            $_SESSION['error_message'] = "Invalid password!";
            header("Location: ../pages/login.php");
        }
    } else {
        $_SESSION['error_message'] = "User not found!";
        header("Location: ../pages/login.php");
    }

    $stmt->close();
    $conn->close();
}
?>
