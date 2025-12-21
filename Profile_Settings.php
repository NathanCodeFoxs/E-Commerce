<?php
require_once __DIR__ . "/PHP/auth.php";
require_once __DIR__ . "/PHP/db.php";

$user_id = $_SESSION['user_id'];

/* ===== FETCH USER DATA ===== */
$stmt = $conn->prepare("SELECT email, phone_number FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $phone);
$stmt->fetch();
$stmt->close();

$email = $email ?? "";
$phone = $phone ?? "";

/* ===== HANDLE UPDATES ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* CHANGE PASSWORD */
    if (isset($_POST['new_password'])) {
        $hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    /* CHANGE PHONE */
    if (isset($_POST['new_phone'])) {
        $stmt = $conn->prepare("UPDATE users SET phone_number = ? WHERE id = ?");
        $stmt->bind_param("si", $_POST['new_phone'], $user_id);
        $stmt->execute();
        $stmt->close();
        $phone = $_POST['new_phone'];
    }

    /* CHANGE EMAIL */
    if (isset($_POST['new_email'])) {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $_POST['new_email'], $user_id);
        $stmt->execute();
        $stmt->close();
        $email = $_POST['new_email'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profile Settings - BBC</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", serif;
            background: linear-gradient(to right, #134E5E, #0B3037);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* =====[ NAVBAR ]===== */
        .header {
            width: 100%;
            height: 100px;
            background: #0b2931;
            display: flex;
            align-items: center;
        }

        .header-logo {
            height: 80px;
            margin: 10px 10px;
        }

        .acro_compa {
            display: inline-block;
            background: linear-gradient(to right, #AC8F45, #6E5A27);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 28px;
            font-weight: bold;
            vertical-align: middle;
        }

        .header span {
            margin-left: auto;
            margin-right: 20px;
        }

        .menu-icon {
            cursor: pointer;
            margin-left: 20px;
        }

        /* =====[ CONTENT ]===== */
        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        .page-title {
            color: #ac8f45;
            font-size: 42px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 4px;
            margin-left: 690px;
            letter-spacing: 2px;
        }

        .settings-card {
            background: #0b2931;
            width: 100%;
            max-width: 700px;
            border-radius: 18px;
            padding: 50px 60px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .field-group {
            margin-bottom: 35px;
        }

        .field-group:last-child {
            margin-bottom: 0;
        }

        .field-label {
            color: #ac8f45;
            font-size: 18px;
            text-align: center;
            margin-bottom: 12px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .field-value {
            background: transparent;
            border: 2px solid #ac8f45;
            color: white;
            padding: 18px 25px;
            font-size: 20px;
            text-align: center;
            border-radius: 8px;
            font-family: "Times New Roman", serif;
            width: 100%;
            outline: none;
        }

        input.field-value:focus {
            border-color: #d4b76a;
            box-shadow: 0 0 8px rgba(172, 143, 69, 0.4);
        }

        .change-btn {
            background: #ac8f45;
            border: none;
            color: white;
            padding: 15px 25px;
            font-size: 18px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-family: "Times New Roman", serif;
            margin-top: 12px;
            transition: background 0.3s, transform 0.2s;
        }

        .change-btn:hover {
            background: #8f7537;
            transform: scale(1.02);
        }

        /* =====[ POPUP ]===== */
        .popup-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100;
        }

        .popup-box {
            background: #0b2931;
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            border: 2px solid #ac8f45;
        }

        .popup-box h3 {
            color: #ac8f45;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .popup-box input {
            width: 90%;
            padding: 15px;
            font-size: 18px;
            margin-top: 15px;
            background: transparent;
            border: 2px solid #ac8f45;
            color: white;
            border-radius: 8px;
            font-family: "Times New Roman", serif;
            outline: none;
        }

        .popup-box input:focus {
            border-color: #d4b76a;
        }

        .popup-box button {
            margin-top: 20px;
            margin-right: 10px;
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            background: #ac8f45;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: "Times New Roman", serif;
            transition: background 0.3s;
        }

        .popup-box button:hover {
            background: #8f7537;
        }

        .popup-box button.cancel {
            background: #555;
        }

        .popup-box button.cancel:hover {
            background: #333;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 32px;
            }

            .settings-card {
                padding: 40px 30px;
            }

            .header-logo {
                height: 60px;
            }

            .acro_compa {
                font-size: 22px;
            }

            .popup-box {
                width: 90%;
                max-width: 400px;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="header">
    <div class="menu-icon" onclick="window.location.href='Profile_Info.php'">
        <img src="Images/home.png" width="40">
    </div>
    <h1 class="page-title">PROFILE SETTINGS</h1>
</div>

<div class="content-wrapper">


<div class="settings-card">

<!-- PASSWORD -->
<div class="field-group">
    <div class="field-label">PASSWORD</div>
    <input type="password" class="field-value" value="************" readonly>
    <button class="change-btn" onclick="openPasswordPopup()">Change</button>
</div>

<!-- PHONE -->
<div class="field-group">
    <div class="field-label">PHONE NUMBER</div>
    <input class="field-value" value="<?= htmlspecialchars($phone) ?>" readonly>
    <button class="change-btn" onclick="openPhonePopup()">Change</button>
</div>

<!-- EMAIL -->
<div class="field-group">
    <div class="field-label">EMAIL</div>
    <input class="field-value" value="<?= htmlspecialchars($email) ?>" readonly>
    <button class="change-btn" onclick="openEmailPopup()">Change</button>
</div>

</div>
</div>

<!-- ===== PASSWORD POPUP ===== -->
<div class="popup-bg" id="passwordPopup">
<form method="POST" class="popup-box">
    <h3>Change Password</h3>
    <input type="password" name="new_password" required>
    <button type="submit">Submit</button>
    <button type="button" class="cancel" onclick="closePopup('passwordPopup')">Cancel</button>
</form>
</div>

<!-- ===== PHONE POPUP ===== -->
<div class="popup-bg" id="phonePopup">
<form method="POST" class="popup-box">
    <h3>Change Phone</h3>
    <input type="text" name="new_phone" required>
    <button type="submit">Submit</button>
    <button type="button" class="cancel" onclick="closePopup('phonePopup')">Cancel</button>
</form>
</div>

<!-- ===== EMAIL POPUP ===== -->
<div class="popup-bg" id="emailPopup">
<form method="POST" class="popup-box">
    <h3>Change Email</h3>
    <input type="email" name="new_email" required>
    <button type="submit">Submit</button>
    <button type="button" class="cancel" onclick="closePopup('emailPopup')">Cancel</button>
</form>
</div>

<script>
function openPasswordPopup(){passwordPopup.style.display='flex'}
function openPhonePopup(){phonePopup.style.display='flex'}
function openEmailPopup(){emailPopup.style.display='flex'}
function closePopup(id){document.getElementById(id).style.display='none'}
</script>

</body>
</html>