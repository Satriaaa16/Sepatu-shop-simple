<?php
session_start();
include('includes/db.php');
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_your_key');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch();

    $amount = $product['price'] * 100; // Convert to cents

    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method' => $_POST['payment_method_id'],
            'confirm' => true,
        ]);

        // Hapus produk setelah pembayaran sukses
        $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);

        echo "Pembayaran berhasil!";
    } catch (\Stripe\Exception\CardException $e) {
        echo "Pembayaran gagal: " . $e->getMessage();
    }
}
?>

<form method="post">
    <input type="hidden" name="product_id" value="<?= $_GET['id'] ?>">
    <button type="submit">Bayar dengan Stripe</button>
</form>
