<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar semua kelas.
     */
    public function index()
    {
        $kelasList = Kelas::latest()->get();
        return view('guru.kelas.index', compact('kelasList'));
    }

    /**
     * Menyimpan data kelas baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
        ]);

        Kelas::create($validated);

        return back()->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kelas yang ada.
     */
    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
        ]);

        $kela->update($validated);

        return back()->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas.
     */
    public function destroy(Kelas $kela)
    {
        // Pastikan tidak ada siswa di kelas ini sebelum menghapus (opsional, tapi praktik yang baik)
        if ($kela->siswas()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kelas karena masih ada siswa di dalamnya.');
        }

        $kela->delete();

        return back()->with('success', 'Data kelas berhasil dihapus.');
    }
}