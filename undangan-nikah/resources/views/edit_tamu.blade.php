<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tamu - Nakata & Sari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: { extend: { colors: { cream: "#fbf6ed", brown: "#3d1e0c", terra: "#d48c6a", terra2: "#b87556" }, fontFamily: { sans: ["Poppins", "sans-serif"], serif: ["Playfair Display", "serif"] } } }
        };
    </script>
</head>
<body class="bg-cream text-brown font-sans h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md border border-terra/20">
        <h2 class="font-serif text-2xl font-bold text-center mb-6 text-brown">Edit Data Tamu</h2>
        
        <form action="{{ url('edit_tamu/'.$data->id) }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Nama Tamu</label>
                <input type="text" name="nama" value="{{ $data->nama }}" required class="w-full bg-cream border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-terra">
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Status Kehadiran</label>
                <select name="kehadiran" required class="w-full bg-cream border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-terra">
                    <option value="hadir" {{ $data->kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak" {{ $data->kehadiran == 'tidak' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="ragu" {{ $data->kehadiran == 'ragu' ? 'selected' : '' }}>Ragu-ragu</option>
                    <option value="belum" {{ $data->kehadiran == 'belum' ? 'selected' : '' }}>Belum Respon</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pesan / Ucapan</label>
                <textarea name="pesan" rows="3" class="w-full bg-cream border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-terra">{{ $data->pesan }}</textarea>
            </div>

            <div class="flex gap-3 mt-4">
                <a href="{{ url('dashboard') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="w-1/2 bg-terra text-white py-2 rounded-lg font-medium hover:bg-terra2 transition">Update</button>
            </div>
        </form>
    </div>
</body>
</html>