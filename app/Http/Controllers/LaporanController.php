<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiSiswa;
use App\Models\Nilai;
use App\Models\Kelas;

class LaporanController extends Controller
{
    public function absensi(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $laporanAbsensi = collect();

        if ($request->filled('kelas_id') && $request->filled('tanggal')) {
            $laporanAbsensi = AbsensiSiswa::where('kelas_id', $request->kelas_id)
                                         ->whereDate('tanggal_absensi', $request->tanggal)
                                         ->with(['siswa', 'guru.user'])
                                         ->get();
        }

        return view('kepala-sekolah.laporan.absensi', [
            'kelasList' => $kelasList,
            'laporanAbsensi' => $laporanAbsensi,
            'selectedKelasId' => $request->kelas_id,
            'selectedTanggal' => $request->tanggal,
        ]);
    }

    public function nilai(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $laporanNilai = collect();

        if ($request->filled('kelas_id')) {
            $laporanNilai = Nilai::whereHas('siswa', function($query) use ($request) {
                                    $query->where('kelas_id', $request->kelas_id);
                                 })
                                 ->with(['siswa', 'ujian.mataPelajaran'])
                                 ->get()
                                 ->sortBy('siswa.nama_lengkap')
                                 ->groupBy('siswa.nama_lengkap');
        }

        return view('kepala-sekolah.laporan.nilai', [
            'kelasList' => $kelasList,
            'laporanNilai' => $laporanNilai,
            'selectedKelasId' => $request->kelas_id,
        ]);
    }
}