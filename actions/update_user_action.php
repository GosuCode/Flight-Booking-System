<?php
session_start();
include('../config.php');  // Include the database configuration

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

        // Prepare SQL to update the user information
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $email, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Your information has been updated successfully!";
            header("Location: ../pages/update_user.php");
        } else {
            $_SESSION['error_message'] = "Failed to update your information!";
            header("Location: ../pages/update_user.php");
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "You need to be logged in to update your profile.";
        header("Location: ../pages/login.php");
        exit();
    }

    $conn->close();
}
?>
