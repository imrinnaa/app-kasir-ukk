<?php
session_start();
include "koneksi.php";

// Pastikan yang akses benar-benar administrator
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Administrator.'); window.location='index.php';</script>";
    exit();
}

if (isset($_POST['registrasi'])) {
    $nama     = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Bisa disesuaikan enkripsinya jika perlu
    $role     = $_POST['role'];

    $query = mysqli_query($koneksi, "INSERT INTO user (NamaLengkap, Username, Password, Role) VALUES ('$nama', '$username', '$password', '$role')");
    
    if ($query) {
echo "<script>alert('Registrasi pengguna baru berhasil! Silakan login kembali dengan akun baru.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Gagal mendaftarkan pengguna!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna - Aplikasi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f8f9fa; }
        header { background-color: #343a40; color: white; padding: 15px 30px; }
        .container { padding: 30px; max-width: 600px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 16px; width: 100%; }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<header>
    <h2>Registrasi Pengguna / Petugas Baru</h2>
</header>

<div class="container">
    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Hak Akses (Role)</label>
                <select name="role" required>
                    <option value="petugas">Petugas</option>
                    <option value="administrator">Administrator</option>
                </select>
            </div>
            <button type="submit" name="registrasi" class="btn btn-primary">Daftarkan Pengguna</button>
        </form>
        <br>
        <a href="index.php">&larr; Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>