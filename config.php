<?php
$host = 'localhost';
$dbname = 'sepatu_shop';
$username = 'root';  // default username XAMPP
$password = '';      // default password XAMPP

// Membuat koneksi
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
