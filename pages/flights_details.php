<?php
include('../utils/auth_check.php');

// Check if a flight ID is passed
if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];

    // Load flights data again
    $json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';
    if (file_exists($json_file)) {
        $json_data = file_get_contents($json_file);
        $flights = json_decode($json_data, true);

        // Find the flight matching the passed flight_id
        $selected_flight = null;
        foreach ($flights as $flight) {
            if ($flight['flight_number'] == $flight_id) {
                $selected_flight = $flight;
                break;
            }
        }
    } else {
        echo "Error: JSON file not found.";
        exit;
    }
} else {
    echo "No flight selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <?php if ($selected_flight): ?>
        <div class="flight-details">
            <h2>Flight Details</h2>
            <img src="../assets/flights/<?php echo htmlspecialchars($selected_flight['img']); ?>" alt="Flight">
            <div class="flight-info">
                <h3>Flight: <?php echo htmlspecialchars($selected_flight['flight_number']); ?></h3>
                <p>Airline: <?php echo htmlspecialchars($selected_flight['airline']); ?></p>
                <p>Departure: <?php echo htmlspecialchars($selected_flight['departure_airport']); ?> at <?php echo date("d M y (D), H:i", strtotime($selected_flight['departure_time'])); ?></p>
                <p>Arrival: <?php echo htmlspecialchars($selected_flight['arrival_airport']); ?> at <?php echo date("d M y (D), H:i", strtotime($selected_flight['arrival_time'])); ?></p>
                <p>Duration: <?php echo htmlspecialchars($selected_flight['duration']); ?></p>
                <p>Price: USD <?php echo number_format($selected_flight['price'], 2); ?></p>
            </div>
            <div class="booking-info">
                <a href="book_flight.php?flight_id=<?php echo urlencode($selected_flight['flight_number']); ?>" class="book-now">Book Now</a>
            </div>
        </div>
    <?php else: ?>
        <p>Flight not found.</p>
    <?php endif; ?>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
