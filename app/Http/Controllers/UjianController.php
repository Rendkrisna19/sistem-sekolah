<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;

class UjianController extends Controller
{
    public function index()
    {
        $ujianList = Ujian::with(['kelas', 'mataPelajaran'])->latest()->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::orderBy('nama_mapel')->get();
        return view('guru.ujian.index', compact('ujianList', 'kelasList', 'mapelList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tanggal_ujian' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
        Ujian::create($validated);
        return back()->with('success', 'Data ujian berhasil ditambahkan.');
    }

    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tanggal_ujian' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
        $ujian->update($validated);
        return back()->with('success', 'Data ujian berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        $ujian->delete();
        return back()->with('success', 'Data ujian berhasil dihapus.');
    }

    public function showNilai(Ujian $ujian)
    {
        // Eager load relasi untuk optimasi
        $ujian->load('kelas', 'mataPelajaran');

        // Ambil semua siswa dari kelas yang terkait dengan ujian ini
        $siswas = Siswa::where('kelas_id', $ujian->kelas_id)
                        ->orderBy('nama_lengkap')
                        ->get();

        // Ambil semua nilai yang sudah ada untuk ujian ini,
        // lalu kelompokkan berdasarkan siswa_id untuk pencarian cepat.
        $nilais = Nilai::where('ujian_id', $ujian->id)
                       ->pluck('nilai', 'siswa_id');

        // Lampirkan data nilai ke setiap objek siswa
        $siswas->each(function($siswa) use ($nilais) {
            // Jika ada nilai, gunakan. Jika tidak, tampilkan null (atau '-')
            $siswa->nilai = $nilais->get($siswa->id);
        });

        // Kirim data ke view baru
        return view('guru.ujian.show_nilai', compact('ujian', 'siswas'));
    }
}