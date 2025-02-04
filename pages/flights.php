<?php
include('../utils/auth_check.php');

$json_file = $_SERVER['DOCUMENT_ROOT'] . '/data/flights.json';
$flights = [];

if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $flights = json_decode($json_data, true);
}

$departure_airports = array_unique(array_column($flights, 'departure_airport'));
$arrival_airports = array_unique(array_column($flights, 'arrival_airport'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Flights</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <h1 class="page-title">Book Flights</h1>
    <p class="page-subtitle">Select the flights you want to take.</p>

    <form method="GET" action="" class="flight-filter-container">
        <!-- Departure Selection -->
        <div class="filter-group">
            <label class="filter-label">Fly from</label>
            <select name="from" class="filter-select">
                <option value="">Airport/City</option>
                <?php foreach ($departure_airports as $airport) { ?>
                    <option value="<?php echo htmlspecialchars($airport); ?>" 
                        <?php echo (isset($_GET['from']) && $_GET['from'] === $airport) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($airport); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="filter-icon">
            <img src="../assets/icons/plane.svg" alt="small plane">
        </div>

        <!-- Arrival Selection -->
        <div class="filter-group">
            <label class="filter-label">Fly to</label>
            <select name="to" class="filter-select">
                <option value="">Somewhere</option>
                <?php foreach ($arrival_airports as $airport) { ?>
                    <option value="<?php echo htmlspecialchars($airport); ?>" 
                        <?php echo (isset($_GET['to']) && $_GET['to'] === $airport) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($airport); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="secondary-button">Search</button>
    </form>

    <?php include '../includes/cards.php'; ?>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
