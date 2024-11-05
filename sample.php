
<?php
// Encrypt function
function encrypt($data, $key) {
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

// Decrypt function
function decrypt($data, $key) {
    $data = base64_decode($data);
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivLength);
    $data = substr($data, $ivLength);
    return openssl_decrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// Example usage
$key = '2b7e151628aed2a6abf7158809cf4f3c'; // 256-bit key
$data = 'SensitiveDataToEncrypt';

// Encrypt data
$encryptedData = encrypt($data, $key);
echo "Encrypted Data: $encryptedData";
$encryptedData = encrypt($encryptedData, $key);
$encryptedData = encrypt($encryptedData, $key);
// Decrypt data
$decryptedData = decrypt($encryptedData, $key);
$decryptedData = decrypt($decryptedData, $key);
echo "\nDecrypted Data: $decryptedData\n";

function generate256BitKey($userDefinedKey) {
    // Ensure that the input key is a string
    if (!is_string($userDefinedKey)) {
        throw new InvalidArgumentException('Input key must be a string.');
    }

    // Hash the user-defined key using SHA-256
    $hashedKey = hash('sha256', $userDefinedKey, true); // true parameter for binary output

    // Ensure that the hash is 32 bytes long (256 bits)
    if (strlen($hashedKey) !== 32) {
        throw new RuntimeException('Hashed key length is not proper.'); //32 bytes (256 bits)
    }

    return $hashedKey;
}

// Example usage
$userKey = 'vrajpatelvrajpatelvrajpatel';
$generatedKey = generate256BitKey($userKey);
echo "Generated 256-bit key: " . bin2hex($generatedKey) . "\n";

?>

