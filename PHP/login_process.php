<?php
session_start();
include 'db.php'; // Make sure db.php is in the same folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $conn->real_escape_string($_POST['account_number']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE account_number='$account'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['account_number'] = $account;

            // Redirect to dashboard (PRG pattern)
            header("Location: ../Dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password!";
            header("Location: ../Login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Account not registered!";
        header("Location: ../Login.php");
        exit();
    }
} else {
    header("Location: ../Login.php");
    exit();
}
?>