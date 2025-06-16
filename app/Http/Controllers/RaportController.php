<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    /**
     * Menampilkan halaman filter untuk memilih siswa.
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        
        
        $siswaList = collect();
        if ($request->filled('kelas_id')) {
            $siswaList = Siswa::where('kelas_id', $request->kelas_id)
                              ->orderBy('nama_lengkap')
                              ->get();
        }

        return view('guru.raport.index', [
            'kelasList' => $kelasList,
            'siswaList' => $siswaList,
            'selectedKelasId' => $request->kelas_id,
        ]);
    }

    /**
     * Menampilkan detail raport untuk satu siswa.
     */
    public function show(Siswa $siswa)
    {
        // Eager load relasi untuk optimasi
        $siswa->load('kelas', 'nilais.ujian.mataPelajaran');

        // Mengelompokkan nilai berdasarkan mata pelajaran
        $nilaiByMapel = $siswa->nilais->groupBy('ujian.mataPelajaran.nama_mapel');
        
        return view('guru.raport.show', compact('siswa', 'nilaiByMapel'));
    }
}