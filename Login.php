<?php
session_start();

// Force browser not to cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Include DB connection
require_once __DIR__ . "/PHP/db.php";

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_number = $_POST['account_number'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($account_number && $password) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE account_number=? LIMIT 1");
        $stmt->bind_param("s", $account_number);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $password_db);
        
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $password_db)) {
                // Correct login: set session
                $_SESSION['user_id'] = $id;
                $_SESSION['account_number'] = $account_number;

                header("Location: Dashboard.php");
                exit;
            } else {
                $login_error = "Invalid account number or password!";
            }
        } else {
            $login_error = "Invalid account number or password!";
        }
        $stmt->close();
    } else {
        $login_error = "Please enter account number and password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - BBC</title>
    <link rel="stylesheet" href="login.css" />
</head>
<style>
/* GENERAL */
body {
    margin: 0;
    padding: 0;
    font-family: "Times New Roman", serif;
    background: linear-gradient(to right, #134E5E,#0B3037);
    overflow: hidden;
}
/* Header */
.header{
    width: 100%;
    height: 100px;
    background: #0b2931;
    display: flex;
    align-items: center;
}

.header-logo{
    height: 80px;
    margin: 10px 10px;
}

.acro_compa{
    display: inline-block;
    background: linear-gradient(to right, #AC8F45, #6E5A27);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 28px;
    font-weight: bold;
    vertical-align: middle;
}

.container {
    display: flex;
    height: 100vh;
    width: 100%;
}

/* LEFT SECTION */
.left-section {
    width: 55%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 100px;
}

.logo-circle {
    width: 350px;
    height: 350px;
    background: rgba(0, 0, 0, 0.25);
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: gold;
}

.logo-icon {
    width: 420px;
    height: 420px;
    margin-bottom: 20px;
    margin-left: 12px;
}

.logo-circle h2 {
    font-size: 32px;
    letter-spacing: 3px;
}

/* RIGHT SECTION */
.right-section {
    width: 45%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 100px;
}

.login-box {
    width: 45%;
    padding: 40px 50px 40px 30px;
    border: 2px solid goldenrod;
    background: rgba(0, 0, 0, 0.15);
    color: white;
    text-align: center;
}

.login-box h1 {
    font-size: 40px;
    margin-bottom: 5px;
}

.welcome-text {
    margin-bottom: 25px;
    font-size: 14px;
}

label {
    display: block;
    text-align: left;
    background: linear-gradient(to right, #AC8F45, #6E5A27);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-top: 15px;
    font-size: 16px;
}

input {
    width: 100%;
    padding: 12px;
    border: 2px solid;
    border-image: linear-gradient(to right, #AC8F45, #6E5A27) 1;
    border-radius: 5px;
    margin-top: 5px;
    background: transparent;
    color: white;
    font-size: 15px;
}

.login-btn {
    width: auto;
    max-width: 100%;
    margin-top: 25px;
    padding: 12px;
    background: linear-gradient(to top, #AC8F45, #6E5A27) ;
    border: none;
    color: #0b2931;
    font-size: 18px;
    font-weight: bold;
    border-radius: 10px;
    cursor: pointer;
}

.small {
    margin-top: 10px;
    font-size: 14px;
}

a {
    background: linear-gradient(to right, #AC8F45, #6E5A27);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-decoration: none;
}

a:hover{
    color: #cda85c;
    text-decoration: underline;
}
</style>
<body>
    <div class="header">
        <img src="Images/logo.png" alt="company logo" class="header-logo">
        <p class="acro_compa">BBC</p>
    </div>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="logo-circle">
                <img src="Images/Login.png" alt="Logo" class="logo-icon">
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="login-box">
                <h1>Login</h1>
                <p class="welcome-text">Welcome to Big Bank Credit!</p>
                
                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<p style="color:red;">'. $_SESSION['login_error'] .'</p>';
                    unset($_SESSION['login_error']); // Clear error after showing
                }
                ?>

                <form action="PHP/login_process.php" method="POST" autocomplete="off">
                    <label>Account Number:</label>
                    <input type="text" name="account_number" required autocomplete="off">

                    <label>Password:</label>
                    <input type="password" name="password" required autocomplete="off">

                <button class="login-btn" type="submit">Login</button>
                </form>

                <p class="small"><a href="#">Forgot Your Password?</a></p>
                <p class="small">Don't have an account? <a href="#">Sign up</a></p>                
            </div>
        </div>
    </div>

<script>
// Clear form values when page is loaded from cache/back button
window.addEventListener('pageshow', function(event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        document.querySelectorAll('input').forEach(input => input.value = '');
    }
});
</script>

</body>
</html>