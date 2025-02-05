<?php
session_start();
include('../utils/auth_check.php'); // Checks 
include('../config.php');  // Includes database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if a flight ID is passed
if (!isset($_GET['flight_id']) || empty($_GET['flight_id'])) {
    echo "No flight selected.";
    exit;
}

$flight_id = $_GET['flight_id'];
$user_name = $_SESSION['username'];

// Load flight data from JSON
$json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';
if (!file_exists($json_file)) {
    echo "Error: JSON file not found.";
    exit;
}

$json_data = file_get_contents($json_file);
$flights = json_decode($json_data, true);

if ($flights === null) {
    echo "Error decoding JSON: " . json_last_error_msg();
    exit;
}

$selected_flight = null;
foreach ($flights as $flight) {
    if (strcasecmp($flight['flight_number'], $flight_id) == 0) {
        $selected_flight = $flight;
        break;
    }
}

if (!$selected_flight) {
    echo "Flight not found.";
    exit;
}

// Check if the user is logged in before booking
if (!isset($user_name) || empty($user_name)) {
    echo "Please log in to book the flight.";
    exit;
}

// Insert the booking details into the database
$stmt = $conn->prepare("INSERT INTO bookings (user_name, flight_id, booking_date) VALUES (?, ?, NOW())");
$stmt->bind_param("ss", $user_name, $flight_id);

if ($stmt->execute()) {
    echo "Flight booked successfully!";
    header("Location: ../pages/confirmation.php?flight_id=" . urlencode($flight_id));
    exit;
} else {
    echo "Error: " . $stmt->error;
    exit;
}

$stmt->close();
$conn->close();
?>
