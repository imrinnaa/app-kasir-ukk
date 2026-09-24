<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stok Barang - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #dee2e6; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #f1f3f5; }
        .badge-warning { background-color: #ffc107; padding: 5px 10px; border-radius: 4px; color: #000; font-weight: bold; }
        .badge-success { background-color: #28a745; padding: 5px 10px; border-radius: 4px; color: #fff; }
    </style>
</head>
<body>

<header>
    <h2>Informasi Stok Barang</h2>
    <div>
        <a href="index.php" style="color: white; text-decoration: none; margin-right: 15px;">&larr; Kembali ke Dashboard</a>
        <span>Halo, <b><?php echo $_SESSION['nama']; ?></b></span>
    </div>
</header>

<div class="container">
    <div class="card">
        <h3>Monitoring Stok Produk Toko</h3>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga Satuan</th>
                    <th>Sisa Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY Stok ASC");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['NamaProduk']; ?></td>
                    <td>Rp <?php echo number_format($d['Harga'], 0, ',', '.'); ?></td>
                    <td><b><?php echo $d['Stok']; ?></b></td>
                    <td>
                        <?php if ($d['Stok'] <= 5) { ?>
                            <span class="badge-warning">Stok Menipis!</span>
                        <?php } else { ?>
                            <span class="badge-success">Aman</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>