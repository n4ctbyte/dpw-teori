<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $nama_tamu = $request->query('to', 'Tamu Undangan');
    $query_pesan = DB::table('tamu')->where('kehadiran', '!=', 'belum')->orderBy('waktu', 'desc')->get();
    return view('undangan', compact('nama_tamu', 'query_pesan'));
});

Route::post('/simpan_pesan', function (Request $request) {
    DB::table('tamu')->updateOrInsert(
        ['nama' => $request->nama], 
        
        [
            'kehadiran' => $request->kehadiran,
            'pesan' => $request->pesan ?? '',
        ]
    );
    return back();
});

Route::get('/login', function () {
    if (session('login_admin')) return redirect('/dashboard');
    return view('login');
});

Route::post('/login', function (Request $request) {
    if ($request->username === 'admin' && $request->password === 'admin123') {
        session(['login_admin' => true]);
        return redirect('/dashboard');
    }
    return back()->with('error', true);
});

Route::get('/logout', function () {
    session()->forget('login_admin');
    return redirect('/login');
});

Route::get('/dashboard', function () {
    if (!session('login_admin')) return redirect('/login');
    
    $total_tamu = DB::table('tamu')->count();
    $hadir = DB::table('tamu')->where('kehadiran', 'hadir')->count();
    $tidak_hadir = DB::table('tamu')->where('kehadiran', 'tidak')->count();
    $belum = DB::table('tamu')->where('kehadiran', 'belum')->count();
    $daftar_tamu = DB::table('tamu')->orderBy('waktu', 'desc')->get();
    
    return view('dashboard', compact('total_tamu', 'hadir', 'tidak_hadir', 'belum', 'daftar_tamu'));
});

Route::get('/tambah_tamu', function () {
    if (!session('login_admin')) return redirect('/login');
    return view('tambah_tamu');
});

Route::post('/tambah_tamu', function (Request $request) {
    if (!session('login_admin')) return redirect('/login');
    DB::table('tamu')->insert([
        'nama' => $request->nama,
        'kehadiran' => $request->kehadiran,
        'pesan' => $request->pesan,
    ]);
    return redirect('/dashboard');
});

Route::get('/edit_tamu/{id}', function ($id) {
    if (!session('login_admin')) return redirect('/login');
    $data = DB::table('tamu')->where('id', $id)->first();
    if (!$data) return redirect('/dashboard');
    return view('edit_tamu', compact('data'));
});

Route::post('/edit_tamu/{id}', function (Request $request, $id) {
    if (!session('login_admin')) return redirect('/login');
    DB::table('tamu')->where('id', $id)->update([
        'nama' => $request->nama,
        'kehadiran' => $request->kehadiran,
        'pesan' => $request->pesan,
    ]);
    return redirect('/dashboard');
});

Route::get('/hapus_tamu/{id}', function ($id) {
    if (!session('login_admin')) return redirect('/login');
    DB::table('tamu')->where('id', $id)->delete();
    return redirect('/dashboard');
});

Route::get('/default-laravel', function () {
    return view('welcome');
});

Route::post('/update_undangan', function (Request $request) {
    $data = $request->except('_token');
    $exists = DB::table('pengaturan')->first();
    
    if ($exists) {
        DB::table('pengaturan')->where('id', $exists->id)->update($data);
    } else {
        DB::table('pengaturan')->insert($data);
    }
    
    return back();
});