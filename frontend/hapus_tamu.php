<?php
if (!isset($_COOKIE['login_admin']) || $_COOKIE['login_admin'] !== 'true') {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tamu WHERE id = $id");

header("Location: dashboard.php");
exit;
?>