<?php
session_start();
include 'config.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $result = $conn->query("SELECT * FROM products WHERE nama LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM products");
}

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $result = $conn->query("SELECT * FROM products WHERE nama LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM products");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>ACCESS DENIED</title>
    </head>
    <body style='background:black; color:red; text-align:center; font-family:monospace;'>
        <h1>🚨 ACCESS DENIED 🚨</h1>
        <h2>GGGGEEEEEEEEEEEEEEEEEEEETTTTTTTTTTT OUUUUUUUUUUUUUUUUUUUTTTTTTTTTTTT!!!!! 😡🔥🔥🔥</h2>
        <audio autoplay>
            <source src='../assets/sound/getout.mp3' type='audio/mpeg'>
        </audio>
        <script>
            setTimeout(() => {
                alert('GET OUTTTTTTTTTTTTTTTTTTTT!!! 😤');
                window.location.href='../php/login.php';
            }, 3000);
        </script>
    </body>
    </html>
    ";
    exit;
}

// Tambah produk
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $conn->query("INSERT INTO products (nama, harga, deskripsi) VALUES ('$nama','$harga','$deskripsi')");
    header("Location: admin.php");
    exit;
}

// Hapus produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: admin.php");
    exit;
}

$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}
th {
    background: #007bff;
    color: white;
}
form input, form textarea, form button {
    width: 100%;
    box-sizing: border-box;
}

body { font-family: Arial; background:#f4f4f4; margin:20px; }
.container { background:white; padding:20px; border-radius:8px; max-width:800px; margin:auto; }
table { width:100%; border-collapse:collapse; }
th, td { border:1px solid #ddd; padding:8px; }
th { background:#007bff; color:white; }
form { margin-bottom:20px; background:#eef; padding:10px; border-radius:8px; }
input, textarea { width:100%; padding:8px; margin:4px 0; border:1px solid #ccc; border-radius:4px; }
button { padding:8px 12px; border:none; background:#007bff; color:white; border-radius:4px; cursor:pointer; }
a.logout { float:right; text-decoration:none; color:white; background:red; padding:6px 12px; border-radius:4px; }
</style>
</head>
<body>
<div class="container">
    <h2>Admin Panel 
        <a href="logout.php" class="logout">Logout</a>
    </h2>

    <!-- 🔍 Search Bar -->
<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="Cari produk..."
        value="<?= htmlspecialchars($search ?? '') ?>">
    <button type="submit">Cari</button>
    <a href="admin.php" class="reset">Reset</a>
</form>


    <!-- 🛒 Form Tambah Produk -->
    <form method="POST" style="background:#eef; padding:15px; border-radius:8px; margin-bottom:20px;">
        <input type="text" name="nama" placeholder="Nama Produk" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <textarea name="deskripsi" placeholder="Deskripsi" rows="3" required></textarea>
        <button type="submit" name="add">Tambah Produk</button>
    </form>

    <!-- 📋 Tabel Produk -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
