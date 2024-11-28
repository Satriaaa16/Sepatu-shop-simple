<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

include('config.php');

// Ambil log aktivitas dari database
$logs = $pdo->query("SELECT message, created_at FROM activity_logs ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('https://source.unsplash.com/1600x900/?logs,activity') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }
        .log-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            backdrop-filter: blur(10px);
        }
        .log-container h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
        }
        .log-item {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f8f9fa;
            border-left: 5px solid #007bff;
            transition: all 0.3s ease;
        }
        .log-item:hover {
            background-color: #f1f1f1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .log-item i {
            color: #28a745;
            margin-right: 10px;
        }
        .log-item small {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .btn-back {
            margin-top: 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #0056b3;
            cursor: pointer;
        }
        .empty-message {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 500;
        }
        /* Add custom scroll bar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="log-container">
            <h2 class="text-center">Log Aktivitas <i class="fas fa-history"></i></h2>
            <div>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <div class="log-item">
                            <i class="fas fa-check-circle"></i> 
                            <?= htmlspecialchars($log['message']) ?> 
                            <small class="text-muted">(<?= $log['created_at'] ?>)</small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-message text-center">Belum ada aktivitas terbaru.</p>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <a href="Homepageu.php" class="btn btn-back">Kembali ke Halaman Beranda</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
