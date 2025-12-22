<?php
include 'db.php';
include 'encryption.php'; // Only needed if you want to keep email/phone encrypted

// User data
/*
$name = "Eric Nathan";
$account_number = "1111111111";
$password = "password";
$email = "nathan@gmail.com";
$phone_number = "0969784312";
*/

// Another example user
/*
$name = "John Doe";
$account_number = "1234567890";
$password = "mypassword";
$email = "johndoe@gmail.com";
$phone_number = "0987654321";
*/

$name = "Euri";
$account_number = "052005";
$password = "asdasdasd";
$email = "eurimiguel.villanueva@cvsu.edu";
$phone_number = "09753354503";


// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Do NOT encrypt name
$plain_name = $name;

// Optionally encrypt email and phone
$encrypted_email = encryptData($email);
$encrypted_phone = encryptData($phone_number);

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, account_number, password, email, phone_number) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $plain_name, $account_number, $hashed_password, $encrypted_email, $encrypted_phone);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;

    // Initial balance
    $balance_stmt = $conn->prepare("INSERT INTO balances (user_id, balance) VALUES (?, ?)");
    $initial_balance = 0.00;
    $balance_stmt->bind_param("id", $user_id, $initial_balance);
    $balance_stmt->execute();
    $balance_stmt->close();

    // Generate OTP
    $otp_code = rand(100000, 999999);
    $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    $otp_stmt = $conn->prepare("INSERT INTO user_otp (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
    $otp_stmt->bind_param("iss", $user_id, $otp_code, $expires_at);
    $otp_stmt->execute();
    $otp_stmt->close();

    echo "User added successfully!<br>";
    echo "Temporary OTP for login: $otp_code"; // for testing
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();