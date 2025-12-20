<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION['tmp_user_id'])) {
    header("Location: ../Login.php");
    exit();
}

$user_id = $_SESSION['tmp_user_id'];
$otp = implode('', $_POST['otp'] ?? []);

if (strlen($otp) !== 6) {
    die("Invalid OTP");
}

$stmt = $conn->prepare("
    SELECT id 
    FROM user_otp
    WHERE user_id = ?
      AND otp_code = ?
      AND is_used = 0
      AND expires_at >= NOW()
    ORDER BY id DESC
    LIMIT 1
");
$stmt->bind_param("is", $user_id, $otp);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("OTP invalid or expired");
}

$row = $result->fetch_assoc();

// Mark OTP used
$stmt = $conn->prepare("UPDATE user_otp SET is_used = 1 WHERE id = ?");
$stmt->bind_param("i", $row['id']);
$stmt->execute();
$stmt->close();

// 🔓 LOGIN SUCCESS
$_SESSION['user_id'] = $user_id;
unset($_SESSION['tmp_user_id']);

header("Location: ../Dashboard.php");
exit();
