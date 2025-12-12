<?php
// Database connection
$host = "localhost";  // XAMPP default
$user = "root";       // XAMPP default
$pass = "";           // XAMPP default
$db   = "bank_db";    // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>