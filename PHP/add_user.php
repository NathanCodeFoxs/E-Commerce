<?php
include 'db.php';

// User data to insert
$name = "John Doe";
$account_number = "1234567890";
$password = "mypassword";        // raw password
$email = "johndoe@gmail.com";    // required field in new table
$phone_number = "0987654321";    // optional

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (name, account_number, password, email, phone_number) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $account_number, $hashed_password, $email, $phone_number);

if ($stmt->execute()) {
    // Optional: create initial balance row for the user
    $user_id = $stmt->insert_id;
    $balance_stmt = $conn->prepare("INSERT INTO balances (user_id, balance) VALUES (?, ?)");
    $initial_balance = 0.00;
    $balance_stmt->bind_param("id", $user_id, $initial_balance);
    $balance_stmt->execute();
    $balance_stmt->close();

    echo "User added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>