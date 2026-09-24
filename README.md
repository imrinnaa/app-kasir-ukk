# Aplikasi Kasir Toko (UKK RPL Paket 4)

Aplikasi Kasir berbasis web menggunakan PHP Native dan MySQL untuk memenuhi Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak (RPL) Paket 4.

## Fitur Utama
- **Multi-User (Hak Akses):**
  - **Administrator:** Akses penuh termasuk manajemen data barang, stok, transaksi, laporan, serta registrasi pengguna/petugas baru.
  - **Petugas (Kasir):** Akses pendataan barang, stok, dan melakukan transaksi penjualan serta cetak struk.
- **Manajemen Barang & Stok:** Menambah, mengedit, dan menghapus data produk serta memantau ketersediaan stok.
- **Transaksi Penjualan:** Melakukan proses transaksi kasir dan mencetak bukti pembayaran.

## Cara Instalasi & Menjalankan Program
1. Clone atau download repositori ini ke dalam folder `htdocs` XAMPP Anda (`C:\xampp\htdocs\app-kasir`).
2. Nyalakan **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Buka phpMyAdmin di browser melalui alamat `http://localhost/phpmyadmin`.
4. Buat database baru dengan nama `db_kasir_toko`, lalu import file SQL yang tersedia.
5. Jalankan aplikasi di browser melalui alamat: `http://localhost/app-kasir/login.php`
