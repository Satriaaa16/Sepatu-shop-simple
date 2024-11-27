<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/$image");

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)");
    $stmt->execute(['name' => $name, 'price' => $price, 'description' => $description, 'image' => $image]);

    header('Location: dashboard.php');
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Nama Sepatu">
    <input type="number" name="price" placeholder="Harga">
    <textarea name="description" placeholder="Deskripsi"></textarea>
    <input type="file" name="image">
    <button type="submit">Upload</button>
</form>
