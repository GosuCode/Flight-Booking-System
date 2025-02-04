<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if flight_id is provided
if (!isset($_GET['flight_id']) || empty($_GET['flight_id'])) {
    $_SESSION['error_message'] = "No flight selected.";
    header("Location: ../pages/flights.php");
    exit;
}

$flight_id = $_GET['flight_id'];

// Load flights data
$json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';
if (!file_exists($json_file)) {
    $_SESSION['error_message'] = "Flight data not available.";
    header("Location: ../pages/flights.php");
    exit;
}

$json_data = file_get_contents($json_file);
$flights = json_decode($json_data, true);

if ($flights === null) {
    $_SESSION['error_message'] = "Error loading flight data: " . json_last_error_msg();
    header("Location: ../pages/flights.php");
    exit;
}

// Find the selected flight
$selected_flight = null;
foreach ($flights as $flight) {
    if (strcasecmp($flight['flight_number'], $flight_id) == 0) {
        $selected_flight = $flight;
        break;
    }
}

if (!$selected_flight) {
    $_SESSION['error_message'] = "Flight not found.";
    header("Location: ../pages/flights.php");
    exit;
}

// Process booking (Store in session or database as required)
$_SESSION['booked_flight'] = $selected_flight;

// Redirect to confirmation page
header("Location: ../pages/confirmation.php");
exit;
?>
