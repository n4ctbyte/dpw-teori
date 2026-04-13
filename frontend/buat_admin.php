<?php
require 'koneksi.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $query)) {
    echo "Akun admin berhasil dibuat! Silakan hapus file ini dari server demi keamanan.";
} else {
    echo "Gagal membuat admin: " . mysqli_error($conn);
}
?>