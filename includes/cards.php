<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure we have the data
if (!isset($flights) || !is_array($flights)) {
    $json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';  // Absolute path
    
    // Check if file exists
    if (!file_exists($json_file)) {
        echo "Error: JSON file not found at: " . $json_file;
        return;
    }

    // Try to read the file
    $json_data = file_get_contents($json_file);
    if ($json_data === false) {
        echo "Error: Unable to read JSON file";
        return;
    }

    // Try to decode the JSON
    $flights = json_decode($json_data, true);
    if ($flights === null) {
        echo "Error loading flight data: " . json_last_error_msg();
        echo "<br>Raw JSON data:<br>";
        echo htmlspecialchars($json_data);
        return;
    }
}
?>


<div class="flights-grid">
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
                <a href="#" class="book-btn">BOOK NOW</a>
            </div>
        </div>
    <?php } ?>
</div>