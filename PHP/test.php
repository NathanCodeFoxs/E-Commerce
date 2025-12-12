<?php
// Include database connection
include 'db.php';

// Test connection
if ($conn) {
    echo "Connected to Bank_DB successfully!";
} else {
    echo "Connection failed!";
}
?>