<?php
session_start();

if (!isset($_SESSION['booked_flight'])) {
    $_SESSION['error_message'] = "No flight booked.";
    header("Location: /flights.php");
    exit;
}

$flight = $_SESSION['booked_flight'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="confirmation">
        <h2>Booking Confirmed</h2>
        <p>Your flight <strong><?php echo htmlspecialchars($flight['flight_number']); ?></strong> has been booked successfully.</p>
        <p>Airline: <?php echo htmlspecialchars($flight['airline']); ?></p>
        <p>Departure: <?php echo htmlspecialchars($flight['departure_airport']); ?> at 
            <?php echo date("d M y (D), H:i", strtotime($flight['departure_time'])); ?></p>
        <p>Arrival: <?php echo htmlspecialchars($flight['arrival_airport']); ?> at 
            <?php echo date("d M y (D), H:i", strtotime($flight['arrival_time'])); ?></p>
        <p>Duration: <?php echo htmlspecialchars($flight['duration']); ?></p>
        <p>Price: USD <?php echo number_format($flight['price'], 2); ?></p>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
