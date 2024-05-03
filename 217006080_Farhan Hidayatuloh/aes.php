<?php

// Fungsi untuk enkripsi file menggunakan AES
function encryptFile($file, $password, $destinationFolder) {
    $key = hash('sha256', $password, true);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt(file_get_contents($file['tmp_name']), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $encryptedFileName = $destinationFolder . "/encrypted_" . $file['name'];
    file_put_contents($encryptedFileName, $iv . $encryptedData);
    return $encryptedFileName;
}

// Fungsi untuk mendekripsi file menggunakan AES
function decryptFile($file, $password, $destinationFolder) {
    $key = hash('sha256', $password, true);
    $data = file_get_contents($file['tmp_name']);
    $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $data = openssl_decrypt(substr($data, openssl_cipher_iv_length('aes-256-cbc')), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $decryptedFileName = $destinationFolder . "/decrypted_" . substr($file['name'], 10); // Remove 'encrypted_' prefix
    file_put_contents($decryptedFileName, $data);
    return $decryptedFileName;
}

// Menangani permintaan enkripsi dan dekripsi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["encrypt"])) {
        if ($_FILES["file"]["error"] > 0) {
            $message = "Error: " . $_FILES["file"]["error"];
        } else {
            $file = $_FILES["file"];
            $password = $_POST["password"];
            $destinationFolder = "encrypted_files"; // Folder penyimpanan file terenkripsi
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true); // Buat folder jika belum ada
            }
            $encryptedFileName = encryptFile($file, $password, $destinationFolder);
            $message = "File encrypted successfully. Download <a href='$encryptedFileName'>here</a>.";
        }
        header("Location: index.php?message=$message");
        exit();
    } elseif (isset($_POST["decrypt"])) {
        if ($_FILES["file"]["error"] > 0) {
            $message = "Error: " . $_FILES["file"]["error"];
        } else {
            $file = $_FILES["file"];
            $password = $_POST["password"];
            $destinationFolder = "decrypted_files"; // Folder penyimpanan file terdekripsi
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true); // Buat folder jika belum ada
            }
            $decryptedFileName = decryptFile($file, $password, $destinationFolder);
            $message = "File decrypted successfully. Download <a href='$decryptedFileName'>here</a>.";
        }
        header("Location: index.php?message=$message");
        exit();
    }
}

?>
