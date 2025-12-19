<?php
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/auth.php";

$user_id = $_SESSION['user_id'];
$bank_name = $_POST['bank_name'];
$to_account = $_POST['to_account'];
$to_name = $_POST['to_name'];
$amount = floatval($_POST['amount']);

if ($amount <= 0) die("Invalid amount");

// 1. Check sender balance
$stmt = $conn->prepare("SELECT balance FROM balances WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();

if ($balance < $amount) die("Insufficient balance");

// 2. Deduct sender balance
$stmt = $conn->prepare("UPDATE balances SET balance = balance - ? WHERE user_id = ?");
$stmt->bind_param("di", $amount, $user_id);
$stmt->execute();
$stmt->close();

// 3. Record transaction
$stmt = $conn->prepare("
INSERT INTO transactions (user_id, type, bank_name, to_account, to_name, amount)
VALUES (?, 'BANK', ?, ?, ?, ?)
");
$stmt->bind_param("isssd", $user_id, $bank_name, $to_account, $to_name, $amount);
$stmt->execute();
$stmt->close();

header("Location: ../Transfer.php");
exit();
