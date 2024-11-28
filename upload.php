<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

include('config.php');

// Variabel untuk status pesan
$status_message = '';

// Logika upload barang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // Upload gambar ke folder assets/images
    if (move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/$image")) {
        // Simpan barang ke database
        $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $price, $description, $image])) {
            // Simpan log ke tabel activity_logs
            $log_message = "Barang '$name' berhasil ditambahkan dengan harga Rp. $price.";
            $log_stmt = $pdo->prepare("INSERT INTO activity_logs (message) VALUES (?)");
            $log_stmt->execute([$log_message]);

            $status_message = 'Barang berhasil di-upload!';
        } else {
            $status_message = 'Gagal menyimpan barang ke database.';
        }
    } else {
        $status_message = 'Gagal mengupload gambar.';
    }

    // Mencegah form di-submit ulang saat refresh
    header("Location: " . $_SERVER['PHP_SELF'] . "?status=" . urlencode($status_message));
    exit();
}

$status_message = isset($_GET['status']) ? $_GET['status'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: url('https://source.unsplash.com/1600x900/?store,products') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Roboto', sans-serif;
    }
    .upload-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .form-control, .btn {
        border-radius: 30px;
    }
    .btn-upload, .btn-dashboard {
        background-color: #28a745; /* Green color */
        border: none;
    }
    .btn-upload:hover, .btn-dashboard:hover {
        background-color: #218838; /* Darker green on hover */
    }
    .btn-upload {
        padding: 12px 20px; /* Smaller padding for button size */
        font-size: 14px; /* Smaller font size */
    }
    .btn-dashboard {
        margin-top: 20px;
    }
    .form-label i {
        margin-right: 10px;
        font-size: 18px;
    }
    .btn {
        width: 100%;
        padding: 15px;
        font-size: 16px;
    }
    .fas {
        font-size: 20px;
    }
    .d-flex {
        flex-direction: column;
    }
    .alert {
        margin-bottom: 20px;
    }
</style>

</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="upload-container col-md-6">
            <h2 class="text-center">Upload Barang</h2>

            <?php if ($status_message): ?>
                <div class="alert alert-info text-center">
                    <strong><?php echo $status_message; ?></strong>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag"></i> Nama Barang
                    </label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama barang" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">
                        <i class="fas fa-dollar-sign"></i> Harga
                    </label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="Masukkan harga barang" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="fas fa-pencil-alt"></i> Deskripsi
                    </label>
                    <textarea id="description" name="description" class="form-control" placeholder="Masukkan deskripsi barang" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">
                        <i class="fas fa-image"></i> Gambar
                    </label>
                    <input type="file" id="image" name="image" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-upload">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>

            <!-- Tombol ke Dashboard -->
            <div class="text-center mt-4">
<<<<<<< HEAD
                <a href="Homepagea.php" class="btn btn-dashboard">
=======
                <a href="index.php" class="btn btn-dashboard">
>>>>>>> 9584724433a3029cedbc67bc7bc09e9ed5859674
                    <i class="fas fa-tachometer-alt"></i> Beranda
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
