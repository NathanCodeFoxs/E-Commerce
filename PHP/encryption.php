<?php
require_once __DIR__ . '/env.php';

// Validate encryption environment variable
if (!getenv('ENCRYPTION_KEY')) {
    die('Encryption environment variable ENCRYPTION_KEY is not set.');
}

// Define constant
define('ENCRYPTION_KEY', hash('sha256', getenv('ENCRYPTION_KEY'), true));

/**
 * Encrypt data using AES-256-CBC with a random IV.
 * The IV is prepended to the encrypted data.
 */

// Encryption
function encryptData($data) {
    if ($data === null || $data === '') return null;

    $iv = random_bytes(16); // 16 bytes IV
    $encrypted = openssl_encrypt(
        (string)$data,
        'AES-256-CBC',
        ENCRYPTION_KEY,
        OPENSSL_RAW_DATA,
        $iv
    );

    // Prepend IV and encode to base64
    return base64_encode($iv . $encrypted);
}

// Decryption
function decryptData($data) {
    if ($data === null || $data === '') return null;

    $raw = base64_decode($data, true); // strict decoding
    if ($raw === false || strlen($raw) < 16) {
        return null; // invalid data
    }

    $iv = substr($raw, 0, 16);
    $ciphertext = substr($raw, 16);

    return openssl_decrypt(
        $ciphertext,
        'AES-256-CBC',
        ENCRYPTION_KEY,
        OPENSSL_RAW_DATA,
        $iv
    );
}
