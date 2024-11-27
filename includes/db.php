<?php
$host = 'localhost'; // Atau alamat server database
$dbname = 'sepatu_shop'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database (default untuk XAMPP adalah kosong)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
