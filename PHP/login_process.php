<?php
session_start();
require_once __DIR__ . "/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../Login.php");
    exit();
}

$account = $_POST['account_number'] ?? '';
$password = $_POST['password'] ?? '';

if (!$account || !$password) {
    $_SESSION['login_error'] = "Missing credentials";
    header("Location: ../Login.php");
    exit();
}

// Get user
$stmt = $conn->prepare("
    SELECT id, password, email 
    FROM users 
    WHERE account_number = ?
    LIMIT 1
");
$stmt->bind_param("s", $account);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['login_error'] = "Invalid login";
    header("Location: ../Login.php");
    exit();
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    $_SESSION['login_error'] = "Invalid login";
    header("Location: ../Login.php");
    exit();
}

/* ✅ PASSWORD OK — GENERATE OTP */

// Save temporary user ID in session (user not logged in yet)
$_SESSION['tmp_user_id'] = $user['id'];

// Generate 6-digit OTP
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
$expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// Save OTP to user_otp table
$stmt = $conn->prepare("
    INSERT INTO user_otp (user_id, otp_code, expires_at)
    VALUES (?, ?, ?)
");
$stmt->bind_param("iss", $user['id'], $otp, $expires);
$stmt->execute();
$stmt->close();

/* 🚨 SEND OTP TO EMAIL */
// For now we just log it for testing
error_log("OTP for user {$user['email']}: $otp");

// Optional: use mail() for testing
// $subject = "Your OTP Code";
// $message = "Your OTP is $otp. It expires in 5 minutes.";
// $headers = "From: noreply@bbc.com";
// mail($user['email'], $subject, $message, $headers);

// Redirect to OTP verification page
header("Location: ../otp_verify.php");
exit();