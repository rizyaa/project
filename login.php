<?php
session_start();
include '../php/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../php/admin.php");
            } else {
                header("Location: ../php/user.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - ITStore</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; }
        .box { width:300px; margin:100px auto; background:white; padding:20px; border-radius:8px; text-align:center; }
        input { width:90%; padding:8px; margin:8px 0; border:1px solid #ccc; border-radius:4px; }
        button { width:100%; padding:10px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer; }
        .error { color:red; }
    </style>
</head>
<body>
<div class="box">
    <h2>Login Multi User</h2>
 <form action="process_login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

    <p class="error"><?= $error ?></p>
</div>
</body>
</html>
