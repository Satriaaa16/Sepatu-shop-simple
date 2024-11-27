<?php
require_once 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PVW7IFJcU780EjPWv0UQpTH8m7ezZIYL6aR1JqSwZuJjvL8ZGH6qLO4zEQxFWBSDWNkFuqhZV8HHMxGsi5rxxuE00FiDWILAi'); // Use the correct Secret Key here

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    include('config.php');
    
    // Fetch product details from the database
    $query = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $query->execute([$productId]);
    $product = $query->fetch(PDO::FETCH_ASSOC);

    // Process payment after form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['stripeToken']; // Token from Stripe Checkout
        try {
            // Create charge using Stripe API
            $charge = \Stripe\Charge::create([
                'amount' => $product['price'] * 100,  // Convert price to cents
                'currency' => 'idr',
                'description' => $product['name'],
                'source' => $token,
            ]);
            
            // Delete product after successful payment
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            
            // Redirect to the home page after successful payment
            header('Location: index.php?status=success');
            exit;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle any errors
            $error_message = 'Pembayaran gagal: ' . $e->getMessage();
        }
    }
}

// Fetch all products from the database to display below the payment section
$queryAll = $pdo->prepare("SELECT * FROM products");
$queryAll->execute();
$allProducts = $queryAll->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - <?= htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- FontAwesome for icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
        }
        .product-details {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .product-info {
            display: flex;
            flex-direction: row;
            align-items: center;
        }
        .product-info img {
            max-width: 200px;
            margin-right: 20px;
            border-radius: 10px;
        }
        .product-info h2 {
            margin: 0;
            font-size: 28px;
        }
        .product-info p {
            font-size: 18px;
            margin: 10px 0;
        }
        .payment-section {
            margin-top: 30px;
        }
        .stripe-button {
            margin-top: 20px;
            width: 100%;
            padding: 15px;
            font-size: 16px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .product-list {
            margin-top: 50px;
        }
        .product-card {
            display: inline-block;
            width: 45%; /* Increase width to 45% for larger cards */
            padding: 20px; /* Increase padding for more space inside the card */
            margin: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease; /* Smooth transition effect on hover */
        }

        .product-card:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }

        .product-card img {
            width: 100%;
            max-width: 180px; /* Increase max width of images */
            height: auto;
            border-radius: 10px;
        }

        .product-card h4 {
            font-size: 20px; /* Increase font size for product names */
            margin-top: 10px;
        }

        .product-card p {
            font-size: 18px; /* Increase font size for prices */
        }

        .back-button {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-details card">
            <div class="product-info">
                <img src="/sepatu-shop/assets/images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <div>
                    <h2><?= htmlspecialchars($product['name']); ?></h2>
                    <p><strong>Harga:</strong> Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                    <p><strong>Deskripsi:</strong> <?= htmlspecialchars($product['description']); ?></p>
                </div>
            </div>

            <div class="payment-section">
                <h3>Proses Pembayaran</h3>
                <form action="payment.php?id=<?= htmlspecialchars($product['id']); ?>" method="POST">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_51PVW7IFJcU780EjPWv0UQpTH8m7ezZIYL6aR1JqSwZuJjvL8ZGH6qLO4zEQxFWBSDWNkFuqhZV8HHMxGsi5rxxuE00FiDWILAi"
                            data-amount="<?= $product['price'] * 100; ?>"
                            data-name="<?= htmlspecialchars($product['name']); ?>"
                            data-description="<?= htmlspecialchars($product['description']); ?>"
                            data-currency="idr"
                            data-label="Bayar Sekarang">
                    </script>
                </form>
            </div>

            <!-- Display error message if payment failed -->
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?= htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
        </div>

        <!-- All Products Section -->
        <div class="product-list">
            <h3>Produk Lainnya</h3>
            <div class="row">
                <?php foreach ($allProducts as $prod): ?>
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="/sepatu-shop/assets/images/<?= htmlspecialchars($prod['image']); ?>" alt="<?= htmlspecialchars($prod['name']); ?>">
                            <h4><?= htmlspecialchars($prod['name']); ?></h4>
                            <p>Rp <?= number_format($prod['price'], 0, ',', '.'); ?></p>
                            <a href="payment.php?id=<?= $prod['id']; ?>" class="btn btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Back to Home Button -->
        <div class="back-button">
            <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
