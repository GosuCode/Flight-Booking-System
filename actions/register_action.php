<?php
session_start();
include('../config.php'); // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check for duplicate users
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    echo "Hello";

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "User already exists!";
    } elseif (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Registration successful!";
        } else {
            $_SESSION['error_message'] = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();

    // Redirect back to register page
    header("Location: ../pages/register.php");
    exit();
}
?>
