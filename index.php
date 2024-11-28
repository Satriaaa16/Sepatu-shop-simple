<?php
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
</body>
</html>
