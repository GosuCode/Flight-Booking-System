<?php
include('../utils/auth_check.php');  // authentication check file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flights</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?><!--header content. file found in utils folder-->
    
    <h1>Book Flights</h1>
    <p style="text-align: center; text-">Select the flights you wanna take.</p>
    <?php include '../includes/cards.php'; ?><!--flights cards content. file found in utils folder-->
    
    <?php include '../includes/footer.php'; ?><!--footer content. file found in utils folder-->
</body>
</html>