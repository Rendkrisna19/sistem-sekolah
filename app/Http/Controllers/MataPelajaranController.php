<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapelList = MataPelajaran::latest()->get();
        return view('guru.mapel.index', compact('mapelList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|unique:mata_pelajarans,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
        ]);
        MataPelajaran::create($validated);
        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|unique:mata_pelajarans,kode_mapel,' . $mapel->id,
            'nama_mapel' => 'required|string|max:255',
        ]);
        $mapel->update($validated);
        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mapel)
    {
        // Tambahkan validasi jika mapel sudah dipakai di jadwal
        $mapel->delete();
        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}