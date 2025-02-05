<?php
session_start();
include('../config.php');  // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../pages/login.php");
    exit;
}

$user_name = $_SESSION['username'];

// Fetch user bookings
$stmt = $conn->prepare("SELECT booking_id, flight_id FROM bookings WHERE user_name = ?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

// Load flights data from JSON
$json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';
if (!file_exists($json_file)) {
    echo "Error: Flight data file not found.";
    exit;
}

$json_data = file_get_contents($json_file);
$flights = json_decode($json_data, true);
if ($flights === null) {
    echo "Error decoding JSON: " . json_last_error_msg();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h2>Your Booked Flights</h2>

        <?php
        if ($result->num_rows > 0) {
            echo "<table class='bookings-table'>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Flight Number</th>
                            <th>Airline</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result->fetch_assoc()) {
                // Find flight details in JSON
                $selected_flight = null;
                foreach ($flights as $flight) {
                    if (strcasecmp($flight['flight_number'], $row['flight_id']) == 0) {
                        $selected_flight = $flight;
                        break;
                    }
                }

                if ($selected_flight) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['booking_id']) . "</td>
                            <td>" . htmlspecialchars($selected_flight['flight_number']) . "</td>
                            <td>" . htmlspecialchars($selected_flight['airline']) . "</td>
                            <td>" . htmlspecialchars($selected_flight['departure_airport']) . " at " . date("d M y (D), H:i", strtotime($selected_flight['departure_time'])) . "</td>
                            <td>" . htmlspecialchars($selected_flight['arrival_airport']) . " at " . date("d M y (D), H:i", strtotime($selected_flight['arrival_time'])) . "</td>
                          </tr>";
                } else {
                    echo "<tr><td colspan='5'>Flight details not found.</td></tr>";
                }
            }

            echo "</tbody></table>";
        } else {
            echo "<p>You have no bookings.</p>";
        }
        ?>

    </div>

    <?php include '../includes/footer.php'; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
