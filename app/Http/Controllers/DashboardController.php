<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Kelas;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard guru.
     */
    public function index()
    {
        $guru = Auth::user()->guru;

        // Jika user tidak memiliki profil guru, redirect atau tampilkan error
        if (!$guru) {
            // Anda bisa memilih untuk redirect ke halaman profil guru
            // atau menampilkan dashboard kosong
            return view('dashboard-guru', [
                'totalSiswa' => 0,
                'totalKelas' => 0,
                'jadwalHariIni' => collect(),
            ]);
        }
        
        // Ambil ID kelas-kelas yang diajar oleh guru ini dari jadwal
        $kelasIds = Jadwal::where('guru_id', $guru->id)
                          ->distinct()
                          ->pluck('kelas_id');
        
        // Hitung total kelas
        $totalKelas = $kelasIds->count();

        // Hitung total siswa dari kelas-kelas tersebut
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();

        // Ambil jadwal mengajar untuk hari ini
        $hariIni = now()->isoFormat('dddd'); // Format nama hari dalam Bahasa Indonesia
        $jadwalHariIni = Jadwal::where('guru_id', $guru->id)
                               ->where('hari', $hariIni)
                               ->with(['kelas', 'mataPelajaran'])
                               ->orderBy('jam_mulai')
                               ->get();

        return view('dashboard-guru', compact('totalSiswa', 'totalKelas', 'jadwalHariIni'));
    }
}