<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Proses hapus data
    $query = "DELETE FROM tamu WHERE id = '$id'";
    mysqli_query($conn, $query);
}

// Redirect kembali ke dashboard setelah berhasil dihapus
header("Location: dashboard.php");
exit;
?>