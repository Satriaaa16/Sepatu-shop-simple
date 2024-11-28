<?php
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    $query = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    if ($query->execute([$username, $password, $role])) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    body {
        background: url('https://source.unsplash.com/1600x900/?shoes,store') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Roboto', sans-serif;
    }

    .register-container {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .register-title {
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-register {
        background-color: #5cb85c;
        border: none;
    }

    .btn-register:hover {
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

    .btn-register i {
        margin-right: 8px;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
    }

    .login-link a {
        color: #5cb85c;
    }

    .login-link a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="register-container">
            <h2 class="register-title">Register</h2>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-register btn-block">Register</button>
            </form>

            <div class="login-link">
                <p>Already have an account? <a href="index.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
