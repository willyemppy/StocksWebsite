<?php
//Emperor Anuku
// Database configuration
$servername = "127.0.0.1";
$username = "root"; // MySQL username
$password = "Password"; // MySQL password
$database = "Stocks_Website"; // database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
