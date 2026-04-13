<?php
if (!isset($_COOKIE['login_admin']) || $_COOKIE['login_admin'] !== 'true') {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

$total_tamu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu"))['total'];
$hadir = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu WHERE kehadiran = 'hadir'"))['total'];
$tidak_hadir = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu WHERE kehadiran = 'tidak'"))['total'];
$belum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu WHERE kehadiran = 'belum'"))['total'];

$daftar_tamu = mysqli_query($conn, "SELECT * FROM tamu ORDER BY waktu DESC");
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Nakata & Sari</title>
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
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-cream text-brown font-sans h-screen flex flex-col md:flex-row overflow-hidden">

    <div class="md:hidden bg-cream border-b border-gray-300 p-4 flex justify-between items-center z-30 shadow-sm relative">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-300 shrink-0"></div>
            <span class="font-bold text-sm">Nakata - Sari</span>
        </div>
        <button onclick="toggleMobileMenu()" class="p-2 text-brown">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>

    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 w-[260px] bg-cream md:border-r border-gray-300 flex flex-col justify-between p-6 shrink-0 z-40 shadow-xl md:shadow-none transition-transform duration-300 ease-in-out">
        <div>
            <div class="hidden md:flex items-center gap-3 mb-10">
                <div class="w-12 h-12 rounded-full bg-gray-300 shrink-0"></div>
                <span class="font-bold text-sm">Nakata - Sari</span>
            </div>

            <div class="md:hidden flex justify-between items-center mb-8">
                <span class="font-serif font-bold text-lg text-brown">Menu</span>
                <button onclick="toggleMobileMenu()" class="p-1 text-brown">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <nav>
                <ul class="flex flex-col gap-5 text-sm">
                    <li id="nav-edit" class="cursor-pointer hover:text-terra transition-colors" onclick="switchTab('edit'); if (window.innerWidth < 768) toggleMobileMenu();">
                        Edit Data Landing Page
                    </li>
                    <li id="nav-data" class="cursor-pointer hover:text-terra transition-colors font-bold" onclick="switchTab('data'); if (window.innerWidth < 768) toggleMobileMenu();">
                        Data Tamu
                    </li>
                </ul>
            </nav>
        </div>

        <a href="logout.php" class="bg-terra text-white rounded-full py-2.5 px-5 flex items-center justify-center gap-2 w-full md:w-max hover:bg-terra2 transition-colors text-sm font-medium mt-10 md:mt-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Keluar
        </a>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/20 z-30 hidden md:hidden" onclick="toggleMobileMenu()"></div>

    <main class="flex-1 flex flex-col h-full overflow-hidden w-full">
        <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 sm:p-6 md:p-8 gap-4 border-b border-gray-300/50 sm:border-none w-full">
            <h1 class="font-serif text-lg sm:text-xl md:text-[1.4rem] font-bold text-brown w-full sm:w-auto">
                Selamat Datang Nakata dan Sari!
            </h1>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-start sm:justify-end">
                <a href="undangan.php" target="_blank" class="bg-terra text-white rounded-full py-2 px-4 sm:px-6 text-xs sm:text-sm font-medium hover:bg-terra2 transition-colors flex-1 sm:flex-none whitespace-nowrap text-center">
                    Preview Undangan
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8 pt-0 w-full">
            <div id="view-data" class="block animate-[fadeIn_0.3s_ease-in-out] w-full">
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-serif text-xl font-bold text-brown">Kelola Data Tamu</h2>
                    <a href="tambah_tamu.php" class="bg-brown text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-brown/80 transition-colors">+ Tambah Tamu</a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6">
                    <div class="bg-terra rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center text-white flex flex-col justify-center min-h-[100px] sm:min-h-[140px] shadow-sm">
                        <p class="text-xs sm:text-sm mb-2 sm:mb-4 opacity-90">Total Tamu</p>
                        <p class="text-2xl sm:text-3xl font-serif leading-none"><?php echo $total_tamu; ?></p>
                    </div>
                    <div class="bg-terra rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center text-white flex flex-col justify-center min-h-[100px] sm:min-h-[140px] shadow-sm">
                        <p class="text-xs sm:text-sm mb-2 sm:mb-4 opacity-90">Hadir</p>
                        <p class="text-2xl sm:text-3xl font-serif leading-none"><?php echo $hadir; ?></p>
                    </div>
                    <div class="bg-terra rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center text-white flex flex-col justify-center min-h-[100px] sm:min-h-[140px] shadow-sm">
                        <p class="text-xs sm:text-sm mb-2 sm:mb-4 opacity-90">Tidak Hadir</p>
                        <p class="text-2xl sm:text-3xl font-serif leading-none"><?php echo $tidak_hadir; ?></p>
                    </div>
                    <div class="bg-terra rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center text-white flex flex-col justify-center min-h-[100px] sm:min-h-[140px] shadow-sm">
                        <p class="text-xs sm:text-sm mb-2 sm:mb-4 opacity-90">Belum Respon</p>
                        <p class="text-2xl sm:text-3xl font-serif leading-none"><?php echo $belum; ?></p>
                    </div>
                </div>

                <div class="bg-terra rounded-xl sm:rounded-2xl p-4 sm:p-6 text-white shadow-sm overflow-hidden w-full">
                    <h2 class="font-serif text-lg sm:text-xl font-bold mb-4 sm:mb-6">Data Tamu Masuk</h2>
                    <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
                        <table class="w-full min-w-[600px]">
                            <thead>
                                <tr class="text-left sm:text-center text-xs sm:text-[0.95rem] border-b border-white/20">
                                    <th class="font-medium pb-3 w-[20%]">Waktu</th>
                                    <th class="font-medium pb-3 w-[20%]">Nama</th>
                                    <th class="font-medium pb-3 w-[40%]">Kehadiran & Pesan</th>
                                    <th class="font-medium pb-3 w-[20%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-left sm:text-center text-xs sm:text-sm">
                               <?php while ($row = mysqli_fetch_assoc($daftar_tamu)) : 
                                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                                    $host = $_SERVER['HTTP_HOST'];
                                    $link_undangan = $protocol . "://" . $host . "/frontend/undangan.php?to=" . urlencode($row['nama']); 
                                    
                                    $status_map = [
                                        'hadir' => ['Hadir', 'bg-green-500 text-white'],
                                        'tidak' => ['Tidak Hadir', 'bg-red-500 text-white'],
                                        'ragu'  => ['Ragu', 'bg-yellow-500 text-brown'],
                                        'belum' => ['Belum Respon', 'bg-gray-400 text-white']
                                    ];
                                    $st = $status_map[$row['kehadiran']];
                                ?>
                                <tr class="border-b border-white/10 last:border-0">
                                    <td class="py-4 pr-2 whitespace-nowrap"><?php echo date('d M, H:i', strtotime($row['waktu'])); ?></td>
                                    <td class="py-4 pr-2 font-bold"><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td class="py-4 px-2">
                                        <span class="px-2 py-0.5 rounded-full text-[0.6rem] font-bold uppercase <?php echo $st[1]; ?>">
                                            <?php echo $st[0]; ?>
                                        </span>
                                        <?php if ($row['kehadiran'] != 'belum' && !empty($row['pesan'])): ?>
                                            <div class="mt-1 text-[0.75rem] italic opacity-90">
                                                "<?php echo htmlspecialchars($row['pesan']); ?>"
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 flex flex-wrap gap-1.5 justify-center">
                                        <button onclick="navigator.clipboard.writeText('<?php echo $link_undangan; ?>'); alert('Link disalin!');" class="bg-teal-600 text-white px-3 py-1 rounded text-xs hover:bg-teal-700">Link</button>
                                        <a href="edit_tamu.php?id=<?php echo $row['id']; ?>" class="bg-cream text-brown px-3 py-1 rounded text-xs hover:bg-white">Edit</a>
                                        <a href="hapus_tamu.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Hapus?')" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="view-edit" class="hidden animate-[fadeIn_0.3s_ease-in-out] w-full">
                <div class="bg-terra rounded-xl sm:rounded-2xl p-5 sm:p-6 md:p-10 text-white shadow-sm w-full">
                    <h2 class="font-serif text-lg sm:text-xl font-bold mb-5 sm:mb-6 border-b border-white/20 pb-3">Detail Acara</h2>
                    <div class="mb-6 sm:mb-8">
                        <h3 class="font-serif font-bold text-base sm:text-lg mb-3">Akad</h3>
                        <div class="flex flex-col sm:grid sm:grid-cols-3 gap-3 sm:gap-4">
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Akad 1" />
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Akad 2" />
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Akad 3" />
                        </div>
                    </div>
                    <div class="mb-6 sm:mb-8">
                        <h3 class="font-serif font-bold text-base sm:text-lg mb-3">Resepsi</h3>
                        <div class="flex flex-col sm:grid sm:grid-cols-3 gap-3 sm:gap-4">
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Resepsi 1" />
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Resepsi 2" />
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Resepsi 3" />
                        </div>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-base sm:text-lg mb-3">Lokasi Acara</h3>
                        <div class="w-full sm:w-2/3">
                            <input type="text" class="w-full bg-[#fdf5e4] border-none outline-none rounded-lg sm:rounded-full px-4 sm:px-5 py-2.5 sm:py-3 text-brown text-sm font-medium focus:ring-2 focus:ring-white/50" placeholder="Input Lokasi" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            if (sidebar.classList.contains("-translate-x-full")) {
                sidebar.classList.remove("-translate-x-full");
                overlay.classList.remove("hidden");
            } else {
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
            }
        }

        function switchTab(tab) {
            document.getElementById("view-data").classList.add("hidden");
            document.getElementById("view-edit").classList.add("hidden");
            document.getElementById("nav-data").classList.remove("font-bold");
            document.getElementById("nav-edit").classList.remove("font-bold");

            if (tab === "data") {
                document.getElementById("view-data").classList.remove("hidden");
                document.getElementById("view-data").classList.add("block");
                document.getElementById("nav-data").classList.add("font-bold");
            } else {
                document.getElementById("view-edit").classList.remove("hidden");
                document.getElementById("view-edit").classList.add("block");
                document.getElementById("nav-edit").classList.add("font-bold");
            }
        }
    </script>
</body>
</html>