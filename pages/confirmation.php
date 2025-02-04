<?php
session_start();
include('../config.php');  // Include database connection

// Ensure user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "You need to log in to view the booking details.";
    exit;
}

// Get flight_id from URL
$flight_id = isset($_GET['flight_id']) ? $_GET['flight_id'] : null;

if (!$flight_id) {
    echo "No flight selected.";
    exit;
}

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

// Find the selected flight
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

// Fetch booking details from the database
$user_name = $_SESSION['username'];
$stmt = $conn->prepare("SELECT booking_id, flight_id, booking_date FROM bookings WHERE user_name = ? AND flight_id = ?");
$stmt->bind_param("ss", $user_name, $flight_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <main class="container">
        <section class="booking-details">
            <?php
            if ($result->num_rows > 0) {
                $booking = $result->fetch_assoc();
                // Display booking details
                echo "<h2>Your Booking Details</h2>";
                echo "<p><strong>Booking ID:</strong> " . htmlspecialchars($booking['booking_id']) . "</p>";
                echo "<p><strong>Flight:</strong> " . htmlspecialchars($selected_flight['flight_number']) . "</p>";
                echo "<p><strong>Airline:</strong> " . htmlspecialchars($selected_flight['airline']) . "</p>";
                echo "<p><strong>Departure:</strong> " . htmlspecialchars($selected_flight['departure_airport']) . " at " . date("d M y (D), H:i", strtotime($selected_flight['departure_time'])) . "</p>";
                echo "<p><strong>Arrival:</strong> " . htmlspecialchars($selected_flight['arrival_airport']) . " at " . date("d M y (D), H:i", strtotime($selected_flight['arrival_time'])) . "</p>";
            } else {
                echo "<p>No bookings found for this flight.</p>";
            }
            ?>

        </section>
    </main>

    <?php include '../includes/footer.php'; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
