<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM tamu WHERE id = $id");
$tamu = mysqli_fetch_assoc($result);

if (!$tamu) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kehadiran = mysqli_real_escape_string($conn, $_POST['kehadiran']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $query = "UPDATE tamu SET nama='$nama', kehadiran='$kehadiran', pesan='$pesan' WHERE id=$id";
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
    <title>Edit Tamu - Nakata & Sari</title>
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
        <h2 class="font-serif text-2xl font-bold mb-6 text-center border-b border-white/20 pb-4">Edit Data Tamu</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-sm mb-2 opacity-90">Nama Tamu</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($tamu['nama']); ?>" required class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg px-4 py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" />
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-2 opacity-90">Konfirmasi Kehadiran</label>
                <select name="kehadiran" required class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg px-4 py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50">
                    <option value="hadir" <?php echo ($tamu['kehadiran'] == 'hadir') ? 'selected' : ''; ?>>Hadir</option>
                    <option value="ragu" <?php echo ($tamu['kehadiran'] == 'ragu') ? 'selected' : ''; ?>>Ragu</option>
                    <option value="tidak" <?php echo ($tamu['kehadiran'] == 'tidak') ? 'selected' : ''; ?>>Tidak Hadir</option>
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm mb-2 opacity-90">Pesan</label>
                <textarea name="pesan" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg px-4 py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50 min-h-[100px]"><?php echo htmlspecialchars($tamu['pesan'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="w-full bg-brown text-white font-bold rounded-lg px-6 py-3.5 hover:bg-brown/80 transition-colors text-sm shadow-sm">
                UPDATE DATA
            </button>
        </form>
    </div>
</body>
</html>