<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwalList = Jadwal::with(['kelas', 'guru.user', 'mataPelajaran'])->get();
        $kelasList = Kelas::all();
        $guruList = Guru::with('user')->get();
        $mapelList = MataPelajaran::all();
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Mengelompokkan jadwal berdasarkan hari
        $jadwalByDay = $jadwalList->groupBy('hari');

        return view('guru.jadwal.index', compact('jadwalByDay', 'kelasList', 'guruList', 'mapelList', 'hari'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Jadwal::create($validated);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // ... method update dan destroy
}