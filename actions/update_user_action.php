<?php
session_start();
include('../config.php');  // Includes the database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        
        // Validate input fields
        if (empty($username) || empty($email)) {
            $_SESSION['error_message'] = "All fields are required!";
            header("Location: ../pages/update_user.php");
            exit();
        }

        // Check if username exceeds 10 characters
        if (strlen($username) > 10) {
            $_SESSION['error_message'] = "Username must not exceed 10 characters!";
            header("Location: ../pages/update_user.php");
            exit();
        }

        // Check if the username or email already exists (excluding the current user)
        $stmt = $conn->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->bind_param("ssi", $username, $email, $user_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $_SESSION['error_message'] = "Username already exists!";
            header("Location: ../pages/update_user.php");
            exit();
        }

        // Prepare SQL to update the user information
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $email, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Your information has been updated successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update your information!";
        }

        $stmt->close();
        header("Location: ../pages/update_user.php");
        exit();
    } else {
        $_SESSION['error_message'] = "You need to be logged in to update your profile.";
        header("Location: ../pages/login.php");
        exit();
    }

    $conn->close();
}
?>