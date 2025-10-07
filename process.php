<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config.php';

echo "<pre>DEBUG MODE STARTED</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>POST data:\n";
    print_r($_POST);
    echo "</pre>";

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        die("⚠️ Username atau password kosong!");
    }

    $sql = "SELECT * FROM users WHERE username = '$username'";
    echo "<pre>Query: $sql</pre>";

    $result = $conn->query($sql);

    if (!$result) {
        die("❌ Query error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<pre>Data user ditemukan:\n";
        print_r($user);
        echo "</pre>";

        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            echo "<pre>✅ Login berhasil! Role: {$user['role']}</pre>";

            if ($user['role'] === 'admin') {
                echo "<pre>Redirect ke admin.php...</pre>";
                // header("Location: admin.php"); exit;
            } else {
                echo "<pre>Redirect ke user.php...</pre>";
                // header("Location: user.php"); exit;
            }
        } else {
            die("❌ Password salah!");
        }
    } else {
        die("❌ Username tidak ditemukan!");
    }
} else {
    die("🚫 Akses langsung ke file ini tidak diizinkan!");
}
?>
