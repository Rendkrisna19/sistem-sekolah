<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        // Eager loading untuk relasi kelas dan orangTua
        $siswas = Siswa::with(['kelas', 'orangTua'])->latest()->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('guru.siswa.index', compact('siswas', 'kelasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama_lengkap' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'no_telp' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // Buat siswa
            $siswa = Siswa::create([
                'nis' => $validated['nis'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'kelas_id' => $validated['kelas_id'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
            ]);

            // Buat data orang tua
            $siswa->orangTua()->create([
                'nama_ayah' => $validated['nama_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                'no_telp' => $validated['no_telp'],
            ]);
        });

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'no_telp' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $siswa) {
            // Update siswa
            $siswa->update([
                'nis' => $validated['nis'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'kelas_id' => $validated['kelas_id'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
            ]);

            // Update atau buat data orang tua
            $siswa->orangTua()->updateOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'nama_ayah' => $validated['nama_ayah'],
                    'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                    'nama_ibu' => $validated['nama_ibu'],
                    'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                    'no_telp' => $validated['no_telp'],
                ]
            );
        });

        return back()->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }
}