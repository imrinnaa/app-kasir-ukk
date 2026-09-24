<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .btn-logout { background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; }
        .btn-logout:hover { background-color: #c82333; }
        ul { line-height: 1.8; }
    </style>
</head>
<body>

<header>
    <h2>Aplikasi Kasir Toko</h2>
    <div>
        <span>Halo, <b><?php echo $_SESSION['nama']; ?></b> (<?php echo ucfirst($_SESSION['role']); ?>)</span> | 
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</header>

<div class="container">
    <div class="card">
        <h3>Selamat Datang di Halaman Utama</h3>
        <p>Anda login sebagai: <b><?php echo strtoupper($_SESSION['role']); ?></b></p>
        
        <hr>
        <h4>Menu Utama Aplikasi:</h4>
        <ul>
            <li><a href="barang.php">Pendataan Barang / Produk</a> (Bisa diakses Admin & Petugas)</li>
            <li><a href="stok.php">Stok Barang</a> (Bisa diakses Admin & Petugas)</li>
            <?php if ($_SESSION['role'] == 'administrator') { ?>
                <li><a href="registrasi.php">Registrasi Pengguna / Petugas Baru</a> <span style="color:red; font-size:12px;">(Khusus Administrator)</span></li>
            <?php } ?>
            <li><a href="penjualan.php">Transaksi Penjualan / Pembelian</a></li>
        </ul>
    </div>
</div>

</body>
</html>