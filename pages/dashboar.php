<?php
session_start();
include('includes/db.php');
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>
<h1>Dashboard - Produk Sepatu</h1>
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['price'] ?></td>
                <td><?= $product['description'] ?></td>
                <td><img src="assets/images/<?= $product['image'] ?>" width="100" /></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($_SESSION['user']['role'] == 'admin'): ?>
    <a href="upload.php">Upload Produk</a>
<?php endif; ?>
