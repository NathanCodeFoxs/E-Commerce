<?php
// =====[ Secure Session Start ]=====
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,                  // prevent JS access
        'cookie_secure' => isset($_SERVER['HTTPS']),// only over HTTPS
        'use_strict_mode' => true,                  // reject uninitialized session IDs
        'cookie_samesite' => 'Lax'                  // basic CSRF mitigation
    ]);
}

// =====[ Session Timeout ]=====
$timeout = 900; // 15 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit();
}
$_SESSION['last_activity'] = time();

// =====[ Session Fingerprint ]=====
// Bind session to IP + User-Agent to prevent hijacking
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (!isset($_SESSION['fingerprint'])) {
    $_SESSION['fingerprint'] = hash('sha256', $ip . $ua);
} else {
    if ($_SESSION['fingerprint'] !== hash('sha256', $ip . $ua)) {
        session_unset();
        session_destroy();
        header("Location: Login.php");
        exit();
    }
}

// =====[ Require Login ]=====
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

// =====[ Prevent Back-Button Caching ]=====
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// =====[ Optional: Regenerate Session ID After Login or OTP Verification ]=====
// session_regenerate_id(true); // uncomment after successful login/OTP
