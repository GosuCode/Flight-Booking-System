<?php

session_start();

$servername = "localhost"; // MySQL username
$username = "root"; // MySQL username
$password = "password"; // MySQL password
$dbname = "flight_booking"; // Database

// Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
