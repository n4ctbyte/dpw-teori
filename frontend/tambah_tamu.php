<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $query = "INSERT INTO tamu (nama) VALUES ('$nama')";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Generate Undangan - Nakata & Sari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { cream: "#fbf6ed", brown: "#3d1e0c", terra: "#d48c6a", terra2: "#b87556" },
                    fontFamily: { sans: ["Poppins", "sans-serif"], serif: ["Playfair Display", "serif"], script: ["Dancing Script", "cursive"] }
                }
            }
        };
    </script>
</head>
<body class="bg-cream text-brown font-sans h-screen flex items-center justify-center p-4">
    <div class="bg-terra w-full max-w-[500px] rounded-2xl p-6 sm:p-10 text-white shadow-lg relative">
        <a href="dashboard.php" class="absolute top-4 left-4 text-white/80 hover:text-white font-bold text-xl">&larr;</a>
        <h2 class="font-serif text-2xl font-bold mb-6 text-center border-b border-white/20 pb-4">Buat Link Undangan</h2>
        <form action="" method="POST">
            <div class="mb-6">
                <label class="block text-sm mb-2 opacity-90">Nama Tamu yang Diundang</label>
                <input type="text" name="nama" required placeholder="Contoh: Fikry Efendi" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg px-4 py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" />
            </div>
            <button type="submit" class="w-full bg-brown text-white font-bold rounded-lg px-6 py-3.5 hover:bg-brown/80 transition-colors text-sm shadow-sm">
                GENERATE LINK
            </button>
        </form>
    </div>
</body>
</html>