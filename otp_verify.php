<?php
// Start secure session
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,                 // prevent JS access
        'cookie_secure' => isset($_SERVER['HTTPS']), // only HTTPS
        'use_strict_mode' => true,                // reject uninitialized session IDs
        'cookie_samesite' => 'Lax'                // basic CSRF mitigation
    ]);
}

// Session timeout: 10 minutes for OTP
$timeout = 600; // seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit();
}
$_SESSION['last_activity'] = time();

// Session fingerprint to bind session to IP + browser
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (!isset($_SESSION['fingerprint'])) {
    $_SESSION['fingerprint'] = hash('sha256', $ip . $ua);
} else if ($_SESSION['fingerprint'] !== hash('sha256', $ip . $ua)) {
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit();
}

// Require temporary user for OTP
if (!isset($_SESSION['tmp_user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once __DIR__ . "/PHP/db.php";

$otp_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = implode('', array_map('trim', $_POST['otp'] ?? []));

    if (strlen($entered_otp) !== 6 || !ctype_digit($entered_otp)) {
        $otp_error = "Invalid OTP format";
    } else {
        $stmt = $conn->prepare("
            SELECT id, expires_at 
            FROM user_otp 
            WHERE user_id = ? AND otp_code = ?
            ORDER BY id DESC
            LIMIT 1
        ");
        $stmt->bind_param("is", $_SESSION['tmp_user_id'], $entered_otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $otp_row = $result->fetch_assoc();
            if (strtotime($otp_row['expires_at']) >= time()) {
                // OTP valid → log in user
                $_SESSION['user_id'] = $_SESSION['tmp_user_id'];
                unset($_SESSION['tmp_user_id']);

                // Optional: regenerate session ID to prevent fixation
                session_regenerate_id(true);

                // Optional: delete used OTP
                $stmt_del = $conn->prepare("DELETE FROM user_otp WHERE id = ?");
                $stmt_del->bind_param("i", $otp_row['id']);
                $stmt_del->execute();
                $stmt_del->close();

                header("Location: Dashboard.php");
                exit();
            } else {
                $otp_error = "OTP expired. Please login again.";
                unset($_SESSION['tmp_user_id']);
            }
        } else {
            $otp_error = "Incorrect OTP. Try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OTP Verification - BBC</title>
<style>
body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(to right, #134E5E, #0B3037);
    color: white;
}

.otp-container {
    background: rgba(0,0,0,0.3);
    padding: 30px 40px;
    border-radius: 10px;
    text-align: center;
}

.otp-container h2 { margin-bottom: 20px; }

.otp-inputs input {
    width: 40px;
    height: 50px;
    font-size: 24px;
    text-align: center;
    margin: 0 5px;
    border-radius: 5px;
    border: 2px solid #AC8F45;
    background: transparent;
    color: white;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 18px;
    background: linear-gradient(to top, #AC8F45, #6E5A27);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    color: #0b2931;
}

.timer {
    margin-top: 15px;
    font-size: 14px;
}
</style>
</head>
<body>
<div class="otp-container">
    <h2>Enter OTP</h2>
    <p>We have sent a 6-digit code to your email.</p>
    <?php if($otp_error): ?>
        <p style="color:red;"><?= htmlspecialchars($otp_error) ?></p>
    <?php endif; ?>
    <form method="POST" class="otp-inputs" id="otpForm">
        <?php for($i=0;$i<6;$i++): ?>
            <input type="text" name="otp[]" maxlength="1" required pattern="\d">
        <?php endfor; ?>
        <br>
        <button type="submit">Verify</button>
    </form>
    <div class="timer" id="timer">05:00</div>
</div>

<script>
// Focus move & auto-submit
const inputs = document.querySelectorAll('.otp-inputs input');
inputs.forEach((input, idx) => {
    input.addEventListener('input', () => {
        if (input.value.length === 1 && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
        }
    });
});

// Countdown Timer
let timeLeft = 5 * 60;
const timerEl = document.getElementById('timer');

const countdown = setInterval(() => {
    const minutes = String(Math.floor(timeLeft / 60)).padStart(2, '0');
    const seconds = String(timeLeft % 60).padStart(2, '0');
    timerEl.textContent = `${minutes}:${seconds}`;
    if (timeLeft <= 0) {
        clearInterval(countdown);
        alert("OTP expired. Please login again.");
        window.location.href = "Login.php";
    }
    timeLeft--;
}, 1000);
</script>
</body>
</html>