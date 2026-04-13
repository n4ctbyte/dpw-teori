<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = false;

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = true;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin - Nakata & Sari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { cream: "#fbf6ed", brown: "#3d1e0c", terra: "#d48c6a" },
                    fontFamily: { sans: ["Poppins", "sans-serif"], serif: ["Playfair Display", "serif"], script: ["Dancing Script", "cursive"] }
                }
            }
        };
    </script>
</head>
<body class="bg-cream text-brown font-sans h-screen flex items-center justify-center p-4">
    <div class="bg-terra w-full max-w-[480px] rounded-xl p-6 sm:p-8 md:p-12 text-center shadow-lg">
        <div class="font-script text-white text-[2.5rem] leading-none mb-4">N ♡ S</div>
        <h2 class="font-serif font-bold text-brown text-xl mb-6 leading-snug">Login Dashboard</h2>
        
        <?php if ($error) : ?>
            <p class="text-white text-sm mb-4 font-bold bg-red-500/50 py-2 rounded-lg">Username atau Password salah!</p>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required class="w-full bg-[#d1d5db] border-2 border-transparent outline-none rounded-full px-6 py-3.5 text-gray-700 text-sm mb-4 focus:border-white/50 transition-colors" />
            <input type="password" name="password" placeholder="Password" required class="w-full bg-[#d1d5db] border-2 border-transparent outline-none rounded-full px-6 py-3.5 text-gray-700 text-sm mb-6 focus:border-white/50 transition-colors" />
            <button type="submit" name="login" class="w-full bg-cream text-brown font-bold tracking-widest rounded-full px-6 py-3.5 hover:bg-orange-50 transition-colors text-sm shadow-sm">
                MASUK
            </button>
        </form>
    </div>
</body>
</html>