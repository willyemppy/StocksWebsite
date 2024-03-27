<?php
// Database configuration
$servername = "127.0.0.1";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = ""; // database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
