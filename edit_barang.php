<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE ProdukID='$id'");
$d = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $nama  = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    $update = mysqli_query($koneksi, "UPDATE produk SET NamaProduk='$nama', Harga='$harga', Stok='$stok' WHERE ProdukID='$id'");
    
    if ($update) {
        echo "<script>alert('Data barang berhasil diubah!'); window.location='barang.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data barang!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; }
        .container { padding: 30px; max-width: 500px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 16px; width: 100%; }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<header>
    <h2>Edit Data Barang</h2>
</header>

<div class="container">
    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" value="<?php echo $d['NamaProduk']; ?>" required>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" value="<?php echo $d['Harga']; ?>" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" value="<?php echo $d['Stok']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Perbarui Barang</button>
        </form>
        <br>
        <a href="barang.php">&larr; Kembali ke Data Barang</a>
    </div>
</div>

</body>
</html>