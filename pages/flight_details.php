<?php
session_start();
include('../utils/auth_check.php');
include('../config.php');  // Include database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if a flight ID is passed
if (!isset($_GET['flight_id']) || empty($_GET['flight_id'])) {
    echo "No flight selected.";
    exit;
}

$flight_id = $_GET['flight_id'];

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

// Fetch feedback for the current flight from the database
$stmt = $conn->prepare("SELECT name, comment, created_at FROM feedback WHERE flight_id = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $flight_id);
$stmt->execute();
$result = $stmt->get_result();
$feedbacks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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

    <div class="flight-details">
        <h2>Flight Details</h2>
        <img src="../assets/flights/<?php echo htmlspecialchars($selected_flight['img']); ?>" alt="Flight">
        <div class="flight-info">
            <h3>Flight: <?php echo htmlspecialchars($selected_flight['flight_number']); ?></h3>
            <p>Airline: <?php echo htmlspecialchars($selected_flight['airline']); ?></p>
            <p>Departure: <?php echo htmlspecialchars($selected_flight['departure_airport']); ?> at 
                <?php echo date("d M y (D), H:i", strtotime($selected_flight['departure_time'])); ?></p>
            <p>Arrival: <?php echo htmlspecialchars($selected_flight['arrival_airport']); ?> at 
                <?php echo date("d M y (D), H:i", strtotime($selected_flight['arrival_time'])); ?></p>
            <p>Duration: <?php echo htmlspecialchars($selected_flight['duration']); ?></p>
            <p>Price: USD <?php echo number_format($selected_flight['price'], 2); ?></p>
        </div>
        <div class="booking-info">
            <a href="../actions/book_flight.php?flight_id=<?php echo urlencode($selected_flight['flight_number']); ?>" class="book-now">Book Now</a>
        </div>
    </div>

    <div class="feedback-section">
    <h3>Feedback</h3>

    <?php if (isset($_SESSION['feedback_success'])): ?>
    <p class="success-message"><?php echo $_SESSION['feedback_success']; unset($_SESSION['feedback_success']); ?></p>
    <?php elseif (isset($_SESSION['feedback_error'])): ?>
        <p class="error-message"><?php echo $_SESSION['feedback_error']; unset($_SESSION['feedback_error']); ?></p>
    <?php endif; ?>

    <form action="../actions/feedback_action.php" method="POST">
        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" rows="4" required placeholder="Write your feedback here..."></textarea>

        <input type="hidden" name="user_name" value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
        <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($selected_flight['flight_number']); ?>">

        <button type="submit" class="primary-button">Submit Feedback</button>
    </form>

    <h4>Recent Feedback:</h4>
    <?php if (count($feedbacks) > 0): ?>
        <ul class="feedback-list">
            <?php foreach ($feedbacks as $feedback): ?>
                <li class="feedback-item">
                    <strong><?php echo htmlspecialchars($feedback['name']); ?></strong>
                    <p><?php echo nl2br(htmlspecialchars($feedback['comment'])); ?></p>
                    <small>Posted on: <?php echo date("d M y (D), H:i", strtotime($feedback['created_at'])); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No feedback yet for this flight.</p>
    <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
