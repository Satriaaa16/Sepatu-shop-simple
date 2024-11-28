<?php
include('config.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
<<<<<<< HEAD
    header('Location: Homepagea.php');
=======
    header('Location: index.php');
>>>>>>> 9584724433a3029cedbc67bc7bc09e9ed5859674
}
?>
