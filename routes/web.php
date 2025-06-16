<?php

use Illuminate\Support\Facades\Route;
// Import controller yang akan kita buat
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KepalaSekolahDashboardController;
use App\Http\Controllers\LaporanController;


Route::get('/', function () {
    return view('welcome');
});





// Rute untuk pengguna yang belum login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Rute untuk pengguna yang sudah login (Authenticated)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Rute Dashboard
  Route::middleware(['auth', 'verified'])->group(function () {
    // Ganti rute dashboard guru menjadi seperti ini
    Route::get('/dashboard-guru', [DashboardController::class, 'index'])->name('dashboard.guru');

    // ... (rute dashboard-kepala-sekolah dan lainnya)
});

    Route::get('/dashboard-kepala-sekolah', function () {
        if (auth()->user()->role !== 'kepala_sekolah') abort(403);
        return view('dashboard-kepala-sekolah');
    })->name('dashboard.kepala-sekolah');

    // RUTE CRUD SISWA, KELAS
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class);
    //RUTE CRUD MAPEL,GURU,JADWAL
    Route::resource('mapel', MataPelajaranController::class);
    Route::get('guru', [GuruController::class, 'index'])->name('guru.index');
    
    // Rute untuk memperbarui profil. Perhatikan {user}
    // Ini akan secara otomatis mencari User berdasarkan ID yang dikirim.
    Route::put('guru/{user}', [GuruController::class, 'update'])->name('guru.update');
    
    // Rute untuk menghapus (jika masih diperlukan)
    Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::resource('jadwal', JadwalController::class);


      // Rute untuk Akademik
        Route::resource('ujian', UjianController::class);
        Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::post('nilai', [NilaiController::class, 'store'])->name('nilai.store');
        Route::resource('ujian', UjianController::class);
Route::get('ujian/{ujian}/nilai', [UjianController::class, 'showNilai'])->name('ujian.showNilai');
Route::get('raport', [RaportController::class, 'index'])->name('raport.index');
Route::get('raport/{siswa}', [RaportController::class, 'show'])->name('raport.show');

//RUTE ABSEN SISWA
Route::get('absensi/siswa', [AbsensiController::class, 'createSiswa'])->name('absensi.siswa.create');
Route::post('absensi/siswa', [AbsensiController::class, 'storeSiswa'])->name('absensi.siswa.store');

});

//KEPALA SEKOLAH
  // Prefix dan name ditambahkan agar rute lebih terorganisir
    Route::middleware(['auth'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
        Route::get('dashboard', [KepalaSekolahDashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['auth'])->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('absensi', [LaporanController::class, 'absensi'])->name('absensi.index');
        // ### PERBAIKAN DI SINI: `Route.get` menjadi `Route::get` ###
        Route::get('nilai', [LaporanController::class, 'nilai'])->name('nilai.index');
    });


// Redirect halaman utama ke halaman login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});