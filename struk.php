<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Ambil PenjualanID terakhir yang baru dimasukkan
$penjualan_query = mysqli_query($koneksi, "SELECT * FROM penjualan ORDER BY PenjualanID DESC LIMIT 1");
$penjualan = mysqli_fetch_array($penjualan_query);
$penjualan_id = $penjualan['PenjualanID'];
$pelanggan_id = $penjualan['PelangganID'];

// Ambil data pelanggan
$pelanggan_query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE PelangganID='$pelanggan_id'");
$pelanggan = mysqli_fetch_array($pelanggan_query);

// Ambil detail produk yang dibeli
$detail_query = mysqli_query($koneksi, "SELECT detailpenjualan.*, produk.NamaProduk, produk.Harga FROM detailpenjualan JOIN produk ON detailpenjualan.ProdukID = produk.ProdukID WHERE detailpenjualan.PenjualanID='$penjualan_id'");
$detail = mysqli_fetch_array($detail_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - Aplikasi Kasir</title>
    <style>
        body { font-family: monospace; background-color: #f8f9fa; padding: 20px; }
        .struk-card { background: white; width: 350px; margin: auto; padding: 20px; border: 1px dashed #333; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h3, h4 { text-align: center; margin: 0 0 10px 0; }
        .info { font-size: 14px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 15px; }
        th, td { padding: 6px; text-align: left; }
        th { border-bottom: 1px solid #333; border-top: 1px solid #333; }
        .total { font-weight: bold; text-align: right; font-size: 15px; border-top: 1px solid #333; padding-top: 8px; }
        .btn-print { display: block; width: 100%; background: #007bff; color: white; border: none; padding: 10px; cursor: pointer; font-size: 14px; border-radius: 4px; text-align: center; text-decoration: none; box-sizing: border-box; margin-top: 15px; }
        .btn-print:hover { background: #0056b3; }
        @media print {
            .btn-print, header, a { display: none; }
            body { background: white; padding: 0; }
            .struk-card { border: none; box-shadow: none; width: 100%; }
        }
    </style>
</head>
<body>

<div class="struk-card">
    <h3>TOKO KASIR RPL</h3>
    <h4>Struk Pembayaran Transaksi</h4>
    <div class="info">
        <p>Tanggal: <?php echo $penjualan['TanggalPenjualan']; ?></p>
        <p>Pelanggan: <?php echo $pelanggan['NamaPelanggan']; ?></p>
        <p>Kasir: <?php echo $_SESSION['nama']; ?></p>
    </div>
    <table>
        <thead>
            Item
            <tr>
                <th>Barang</th>
                <th>Jml</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $detail['NamaProduk']; ?></td>
                <td><?php echo $detail['JumlahProduk']; ?></td>
                <td>Rp <?php echo number_format($detail['Subtotal'], 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="total">
        Total: Rp <?php echo number_format($penjualan['TotalHarga'], 0, ',', '.'); ?>
    </div>
    <br>
    <p style="text-align: center; font-size: 12px;">--- Terima Kasih Telah Berbelanja ---</p>

    <button onclick="window.print()" class="btn-print">Cetak / Print Struk</button>
    <br>
    <a href="penjualan.php" style="display: block; text-align: center; text-decoration: none; color: #555; font-size: 14px;">&larr; Transaksi Baru</a>
</div>

</body>
</html>