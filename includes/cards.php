<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load flight data
$json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';
$flights = [];

if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $flights = json_decode($json_data, true);
}

// Get filter values from GET request
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';

// Apply filters if set
if (!empty($from)) {
    $flights = array_filter($flights, function ($flight) use ($from) {
        return $flight['departure_airport'] === $from;
    });
}

if (!empty($to)) {
    $flights = array_filter($flights, function ($flight) use ($to) {
        return $flight['arrival_airport'] === $to;
    });
}
?>

<div class="flights-grid">
    <?php if (empty($flights)) { ?>
        <p>No flights found for the selected route.</p>
    <?php } else { ?>
        <?php foreach ($flights as $flight) { ?>
            <div class="card">
                <img src="../assets/flights/<?php echo htmlspecialchars($flight['img']); ?>" alt="Flight">
                <div class="card-content">
                    <div class="flight-route">
                        <?php echo htmlspecialchars($flight['departure_airport']); ?> to 
                        <?php echo htmlspecialchars($flight['arrival_airport']); ?>
                    </div>
                    <div class="flight-date">
                        <?php echo date("d M y (D)", strtotime($flight['departure_time'])); ?> -
                        <?php echo date("d M y (D)", strtotime($flight['arrival_time'])); ?>
                    </div>
                    <div class="price">USD <?php echo number_format($flight['price'], 2); ?>*</div>
                    <div class="details">
                        Flight: <?php echo htmlspecialchars($flight['flight_number']); ?><br>
                        Airline: <?php echo htmlspecialchars($flight['airline']); ?><br>
                        Duration: <?php echo htmlspecialchars($flight['duration']); ?>
                    </div>
                    <a href="../pages/flight_details.php?flight_id=<?php echo urlencode($flight['flight_number']); ?>" class="book-btn">BOOK NOW</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
