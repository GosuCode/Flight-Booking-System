<?php
include('../config.php');

// Check if user is logged in (session exists)
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "Please log in to submit feedback.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $feedback = $conn->real_escape_string($_POST['feedback']);
    $flight_id = $conn->real_escape_string($_POST['flight_id']);

    // Prepare the SQL query to insert the feedback using prepared statements
    $stmt = $conn->prepare("INSERT INTO feedback (flight_id, name, comment, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $flight_id, $username, $feedback);
    
    if ($stmt->execute()) {
        header("Location: ../pages/flight_details.php?flight_id=" . urlencode($flight_id));
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
