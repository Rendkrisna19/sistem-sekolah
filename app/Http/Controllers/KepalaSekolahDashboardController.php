<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\AbsensiSiswa;

class KepalaSekolahDashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        
        // Menghitung persentase kehadiran hari ini
        $kehadiranHariIni = AbsensiSiswa::whereDate('tanggal_absensi', today())
                                        ->where('status', 'Hadir')
                                        ->count();
        $persentaseKehadiran = ($totalSiswa > 0) ? ($kehadiranHariIni / $totalSiswa) * 100 : 0;

        return view('kepala-sekolah.dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas', 'persentaseKehadiran'));
    }
}