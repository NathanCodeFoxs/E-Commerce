<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['user_account'])) {
    header("Location: Login.php");
    exit();
}

// Prevent back-button cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");