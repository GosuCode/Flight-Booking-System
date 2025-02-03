<?php

session_start();

$servername = "localhost"; // or IP address of your MySQL server
$username = "root"; // MySQL username
$password = "password"; // MySQL password
$dbname = "flight_booking"; // The database you want to use

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
