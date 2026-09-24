<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Proses Hapus Barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM produk WHERE ProdukID='$id'");
    echo "<script>alert('Data barang berhasil dihapus!'); window.location='barang.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendataan Barang - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #dee2e6; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #f1f3f5; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-success { background-color: #28a745; color: white; display: inline-block; margin-bottom: 15px; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>

<header>
    <h2>Pendataan Barang / Produk</h2>
    <div>
        <a href="index.php" style="color: white; text-decoration: none; margin-right: 15px;">&larr; Kembali ke Dashboard</a>
        <span>Halo, <b><?php echo $_SESSION['nama']; ?></b></span>
    </div>
</header>

<div class="container">
    <div class="card">
        <h3>Daftar Barang Toko</h3>
        <hr>
        
        <a href="tambah_barang.php" class="btn btn-success">+ Tambah Barang Baru</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga (Rp)</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY ProdukID DESC");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['NamaProduk']; ?></td>
                    <td>Rp <?php echo number_format($d['Harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $d['Stok']; ?></td>
                    <td>
                        <a href="edit_barang.php?id=<?php echo $d['ProdukID']; ?>" class="btn btn-primary">Edit</a>
                        <a href="barang.php?hapus=<?php echo $d['ProdukID']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>