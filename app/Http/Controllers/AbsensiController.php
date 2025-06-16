<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Menampilkan halaman untuk mengambil absensi siswa.
     */
    public function createSiswa(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $students = collect();
        if ($request->filled('kelas_id') && $request->filled('tanggal_absensi')) {
            $students = Siswa::where('kelas_id', $request->kelas_id)->orderBy('nama_lengkap')->get();

            // Ambil data absensi yang sudah ada untuk hari dan kelas ini
            $existingAbsensi = AbsensiSiswa::where('kelas_id', $request->kelas_id)
                                          ->where('tanggal_absensi', $request->tanggal_absensi)
                                          ->pluck('status', 'siswa_id');

            // Lampirkan status absensi ke setiap siswa
            $students->each(function ($student) use ($existingAbsensi) {
                $student->status = $existingAbsensi->get($student->id, 'Hadir'); // Default 'Hadir'
            });
        }

        return view('guru.absensi.create', [
            'kelasList' => $kelasList,
            'students' => $students,
            'selectedKelasId' => $request->kelas_id,
            'selectedTanggal' => $request->tanggal_absensi ?? now()->format('Y-m-d'),
        ]);
    }

    /**
     * Menyimpan data absensi siswa.
     */
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_absensi' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:siswas,id',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        $guruId = Auth::user()->guru->id;

        foreach ($request->absensi as $data) {
            AbsensiSiswa::updateOrCreate(
                [ // Kondisi pencarian
                    'siswa_id' => $data['siswa_id'],
                    'tanggal_absensi' => $request->tanggal_absensi,
                ],
                [ // Data untuk diupdate atau dibuat
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => $guruId,
                    'status' => $data['status'],
                ]
            );
        }

        return back()->with('success', 'Data absensi berhasil disimpan.');
    }
}