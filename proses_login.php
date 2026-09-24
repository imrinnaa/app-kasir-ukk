<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Cek data user di database
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE Username='$username' AND Password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);
    
    // Simpan sesi login
    $_SESSION['username'] = $data['Username'];
    $_SESSION['nama'] = $data['NamaLengkap'];
    $_SESSION['role'] = $data['Role']; // administrator atau petugas

    // Alihkan ke halaman utama
    header("location:index.php");
} else {
    echo "<script>alert('Username atau Password salah!'); window.location='login.php';</script>";
}
?>