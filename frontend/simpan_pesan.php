<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kehadiran = mysqli_real_escape_string($conn, $_POST['kehadiran']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $cek_tamu = mysqli_query($conn, "SELECT * FROM tamu WHERE nama = '$nama'");

    if (mysqli_num_rows($cek_tamu) > 0) {
        $query = "UPDATE tamu SET kehadiran = '$kehadiran', pesan = '$pesan', waktu = CURRENT_TIMESTAMP WHERE nama = '$nama'";
    } else {
        $query = "INSERT INTO tamu (nama, kehadiran, pesan) VALUES ('$nama', '$kehadiran', '$pesan')";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: undangan.php?to=" . urlencode($nama) . "#msg-list");
        exit;
    }
}
?>