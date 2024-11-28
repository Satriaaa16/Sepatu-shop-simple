<?php
<<<<<<< HEAD
session_start();
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        header('Location: Homepageu.php'); // Redirect to homepage
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    body {
        background: url('https://source.unsplash.com/1600x900/?shoes,store') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Roboto', sans-serif;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .login-title {
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-login {
        background-color: #5cb85c;
        border: none;
    }

    .btn-login:hover {
        background-color: #4cae4c;
    }

    .error-message {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-control, .btn {
        border-radius: 30px;
    }

    label .fas {
        margin-right: 8px;
        color: #5cb85c;
    }

    .btn-login i {
        margin-right: 8px;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
    }

    .register-link a {
        color: #5cb85c;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="login-container">
            <h2 class="login-title">Login</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger error-message"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-login btn-block">Login</button>
            </form>

            <div class="register-link">
                <p>Don't have an account? <a href="daftar.php">Register here</a></p>
            </div>
        </div>
    </div>
=======
include('config.php');

// Handle search query if it is set
$search_term = '';
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
}

// Cek apakah koneksi berhasil
try {
    // Tes koneksi dengan query sederhana
    $pdo->query("SELECT 1");
    $connection_message = "Database berhasil terhubung.";
    $connection_status = "success";
} catch (Exception $e) {
    $connection_message = "Gagal terhubung ke database: " . $e->getMessage();
    $connection_status = "error";
}

// Ambil data produk dari database dengan kondisi pencarian
$query = "SELECT * FROM products WHERE name LIKE :search_term";
$stmt = $pdo->prepare($query);
$stmt->execute(['search_term' => "%$search_term%"]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sepatu-Shop</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS File -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset and basic styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #444;
        }

        /* Header styling */
        header {
            background-color: #fff;
            color: #333;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Styling the logo */
        .logo img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #333;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
        }

        /* Styling the header-right for search bar and navigation */
        .header-right {
            display: flex;
            align-items: center;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-bar input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 25px;
            width: 350px;
            margin-right: 15px;
            outline: none;
        }

        .search-bar input:focus {
            border-color: #4CAF50;
        }

        .search-bar button {
            background-color: #4CAF50;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-bar button:hover {
            background-color: #45a049;
        }

        /* Styling navigation links */
        .nav-links a {
            text-decoration: none;
            color: #333;
            margin-left: 20px;
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #007BFF;
        }

        /* Styling the product cards */
        .product-card {
            display: inline-block;
            width: 280px;
            margin: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            color: #333;
            overflow: hidden; /* Ensure images don't overflow the card */
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 200px; /* Fixed height to ensure all images are the same size */
            object-fit: cover; /* This ensures the image covers the area without stretching */
            border-radius: 8px;
        }

        .product-card h3 {
            font-size: 18px;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }

        .product-card .price {
            font-size: 16px;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 10px;
        }

        .product-card .action-links {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .product-card .action-links a {
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
            transition: color 0.3s;
        }

        .product-card .action-links a:hover {
            color: #0056b3;
        }

        /* Hide the product description by default */
        .product-card .description {
            display: none;
        }

        /* Show the product description when hovering over the card */
        .product-card:hover .description {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .notification.error {
            background-color: #f44336;
        }

        .notification.show {
            opacity: 1;
        }

        /* Main product container */
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="logo">
            <img src="assets/images/logo2.jpg" alt="Sepatu-Shop Logo">
        </div>
        <div class="header-right">
            <!-- Search Bar -->
            <div class="search-bar">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Cari produk..." value="<?= htmlspecialchars($search_term); ?>">
                    <button type="submit"><i class="fas fa-search"></i> Cari</button>
                </form>
            </div>
            <!-- Navigation Links -->
            <div class="nav-links">
                <a href="log_aktivitas.php">Aktivitas Log</a>
                <a href="login.php">Upload Produk</a>
            </div>
        </div>
    </header>

    <!-- Displaying the notification message -->
    <?php if (isset($connection_message)) { ?>
        <div class="notification <?= $connection_status; ?> show"><?= $connection_message; ?></div>
    <?php } ?>

    <h2>Daftar Produk Sepatu</h2>

    <div class="product-container">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product) { ?>
                <div class="product-card">
                    <!-- Product Image -->
                    <img src="/sepatu-shop/assets/images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>">
                    <h3><?= $product['name']; ?></h3>
                    <!-- Product Description (hidden by default) -->
                    <div class="description"><?= $product['description']; ?></div>
                    <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>

                    <div class="action-links">
                        <a href="payment.php?id=<?= $product['id']; ?>"><i class="fas fa-credit-card"></i> Bayar</a> |
                        <a href="delete.php?id=<?= $product['id']; ?>"><i class="fas fa-trash-alt"></i> Hapus</a>
                    </div>
                </div>
            <?php } ?>
        <?php else: ?>
            <p>Tidak ada produk yang ditemukan.</p>
        <?php endif; ?>
    </div>

    <script>
        // Auto-hide notification after 3 seconds
        setTimeout(function() {
            document.querySelector('.notification').classList.remove('show');
        }, 3000);
    </script>
>>>>>>> 9584724433a3029cedbc67bc7bc09e9ed5859674
</body>
</html>
