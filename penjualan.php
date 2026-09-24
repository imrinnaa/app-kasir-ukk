<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Proses Transaksi
if (isset($_POST['proses_transaksi'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat         = "Umum / Alamat Tidak Diisi";
    $telepon        = "-";
    $tanggal        = date('Y-m-d');
    $produk_id      = $_POST['produk_id'];
    $jumlah         = $_POST['jumlah_beli'];

    // 1. Masukkan data pelanggan terlebih dahulu ke tabel pelanggan agar Foreign Key terpenuhi
    $query_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES ('$nama_pelanggan', '$alamat', '$telepon')");
    
    if (!$query_pelanggan) {
        echo "<script>alert('Gagal menyimpan data pelanggan!'); window.location='struk.php';</script>";
        exit();
    }

    // Ambil PelangganID yang baru saja dibuat
    $pelanggan_id = mysqli_insert_id($koneksi);

    // Ambil data produk untuk harga dan stok
    $cek_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE ProdukID='$produk_id'");
    $data_p     = mysqli_fetch_array($cek_produk);
    
    $harga_satuan  = $data_p['Harga'];
    $stok_sekarang = $data_p['Stok'];
    $total_harga   = $harga_satuan * $jumlah;

    if ($jumlah > $stok_sekarang) {
        echo "<script>alert('Gagal! Stok barang tidak mencukupi.'); window.location='penjualan.php';</script>";
        exit();
    }

    // 2. Simpan ke tabel penjualan (menyertakan TanggalPenjualan, TotalHarga, dan PelangganID)
    $query_penjualan = mysqli_query($koneksi, "INSERT INTO penjualan (TanggalPenjualan, TotalHarga, PelangganID) VALUES ('$tanggal', '$total_harga', '$pelanggan_id')");
    
    if ($query_penjualan) {
        $penjualan_id = mysqli_insert_id($koneksi);

        // 3. Simpan ke tabel detailpenjualan
        mysqli_query($koneksi, "INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) VALUES ('$penjualan_id', '$produk_id', '$jumlah', '$total_harga')");

        // 4. Kurangi stok produk
        $stok_baru = $stok_sekarang - $jumlah;
        mysqli_query($koneksi, "UPDATE produk SET Stok='$stok_baru' WHERE ProdukID='$produk_id'");

       echo "<script>alert('Transaksi berhasil! Total: Rp " . number_format($total_harga, 0, ',', '.') . "'); window.location='struk.php';</script>";
    } else {
        echo "<script>alert('Gagal memproses transaksi penjualan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 30px; max-width: 600px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 16px; width: 100%; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
    </style>
</head>
<body>

<header>
    <h2>Transaksi Penjualan / Kasir</h2>
    <div>
        <a href="index.php" style="color: white; text-decoration: none;">&larr; Kembali ke Dashboard</a>
    </div>
</header>

<div class="container">
    <div class="card">
        <h3>Form Pembelian Produk</h3>
        <hr>
        <form method="POST">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" placeholder="Nama Pembeli" required>
            </div>
            <div class="form-group">
                <label>Pilih Produk</label>
                <select name="produk_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    $produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE Stok > 0");
                    while ($p = mysqli_fetch_array($produk)) {
                        echo "<option value='{$p['ProdukID']}'>{$p['NamaProduk']} (Stok: {$p['Stok']} | Harga: Rp " . number_format($p['Harga'], 0, ',', '.') . ")</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Beli</label>
                <input type="number" name="jumlah_beli" min="1" value="1" required>
            </div>
            <button type="submit" name="proses_transaksi" class="btn btn-success">Proses Pembayaran</button>
        </form>
    </div>
</div>

</body>
</html>