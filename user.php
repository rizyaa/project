<?php
session_start();
include 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../php/login.php");
    exit;
}

$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
<title>Halaman User</title>
<style>
body { font-family: Arial; background:#f4f4f4; margin:20px; }
.container { background:white; padding:20px; border-radius:8px; max-width:800px; margin:auto; }
a.logout { float:right; text-decoration:none; color:white; background:red; padding:6px 12px; border-radius:4px; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
th, td { border:1px solid #ddd; padding:8px; }
th { background:#007bff; color:white; }
</style>
</head>
<body>
<div class="container">
    <h2>Selamat Datang, <?= $_SESSION['username'] ?> <a href="logout.php" class="logout">Logout</a></h2>
    <table>
        <tr><th>Nama</th><th>Harga</th><th>Deskripsi</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= $row['harga'] ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
