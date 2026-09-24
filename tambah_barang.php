<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nama  = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    $query = mysqli_query($koneksi, "INSERT INTO produk (NamaProduk, Harga, Stok) VALUES ('$nama', '$harga', '$stok')");
    
    if ($query) {
        echo "<script>alert('Data barang berhasil ditambahkan!'); window.location='barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah barang!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; }
        .container { padding: 30px; max-width: 500px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 16px; width: 100%; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
    </style>
</head>
<body>

<header>
    <h2>Tambah Barang Baru</h2>
</header>

<div class="container">
    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" required>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" required>
            </div>
            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number" name="stok" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-success">Simpan Barang</button>
        </form>
        <br>
        <a href="barang.php">&larr; Kembali ke Data Barang</a>
    </div>
</div>

</body>
</html>