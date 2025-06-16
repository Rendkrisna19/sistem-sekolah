<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Ujian;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        // Hanya ambil ujian yang relevan jika kelas sudah dipilih
        $ujianList = $request->has('kelas_id') 
            ? Ujian::where('kelas_id', $request->kelas_id)->latest()->get()
            : collect(); // koleksi kosong

        $students = collect();
        if ($request->has('kelas_id') && $request->has('ujian_id')) {
            // Ambil siswa dari kelas yang dipilih
            $students = Siswa::where('kelas_id', $request->kelas_id)->orderBy('nama_lengkap')->get();
            // Ambil nilai yang sudah ada untuk siswa & ujian ini
            $existingNilai = Nilai::where('ujian_id', $request->ujian_id)
                                ->whereIn('siswa_id', $students->pluck('id'))
                                ->pluck('nilai', 'siswa_id');
            // Gabungkan nilai ke data siswa
            $students->each(function ($student) use ($existingNilai) {
                $student->nilai = $existingNilai[$student->id] ?? '';
            });
        }
        
        return view('guru.nilai.index', [
            'kelasList' => $kelasList,
            'ujianList' => $ujianList,
            'students' => $students,
            'selectedKelasId' => $request->kelas_id,
            'selectedUjianId' => $request->ujian_id,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'nilais' => 'required|array',
            'nilais.*.siswa_id' => 'required|exists:siswas,id',
            'nilais.*.nilai' => 'nullable|numeric|min:0|max:100',
        ]);
        
        foreach ($request->nilais as $data) {
            // ### PERBAIKAN DI SINI ###
            // Cek jika 'nilai' ada dan bukan string kosong.
            // Ini akan menyimpan nilai '0' tapi mengabaikan input yang kosong.
            if (isset($data['nilai']) && $data['nilai'] !== '') {
                Nilai::updateOrCreate(
                    [ // Kondisi pencarian
                        'ujian_id' => $request->ujian_id,
                        'siswa_id' => $data['siswa_id'],
                    ],
                    [ // Data untuk diupdate atau dibuat
                        'nilai' => $data['nilai'],
                    ]
                );
            }
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }
}