<?php
session_start();
include('includes/db.php');

if ($_SESSION['user']['role'] == 'admin' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus gambar
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch();
    unlink("assets/images/" . $product['image']);

    // Hapus produk dari database
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header('Location: dashboard.php');
}
?>
